document.addEventListener('DOMContentLoaded', function() {
  "use strict";

  /**
   * Apply .scrolled class to the body as the page is scrolled down
   * With reversed color behavior - dark navbar initially, lighter when scrolled
   */
  const toggleScrolled = () => {
    const body = document.querySelector('body');
    const header = document.querySelector('#header');
    if (!header) return;
    
    // Reversed color behavior
    if (window.scrollY > 100) {
      body.classList.add('scrolled');
      header.classList.remove('navbar-dark');
      header.classList.add('navbar-light');
    } else {
      body.classList.remove('scrolled');
      header.classList.remove('navbar-light');
      header.classList.add('navbar-dark');
    }
  };

  document.addEventListener('scroll', toggleScrolled);
  toggleScrolled(); // Run once on page load

  /**
   * Mobile nav toggle - simplified
   */
  const mobileNavToggleBtn = document.querySelector('.mobile-nav-toggle');
  if (mobileNavToggleBtn) {
    mobileNavToggleBtn.addEventListener('click', function() {
      document.body.classList.toggle('mobile-nav-active');
      this.classList.toggle('bi-list');
      this.classList.toggle('bi-x');
    });
  }

  /**
   * Hide mobile nav when clicking a link
   */
  const navLinks = document.querySelectorAll('#navmenu a');
  navLinks.forEach(function(link) {
    link.addEventListener('click', function() {
      if (document.body.classList.contains('mobile-nav-active')) {
        document.body.classList.remove('mobile-nav-active');
        if (mobileNavToggleBtn) {
          mobileNavToggleBtn.classList.add('bi-list');
          mobileNavToggleBtn.classList.remove('bi-x');
        }
      }
    });
  });

  /**
   * Simple active link detection for Laravel routes
   */
  const currentPath = window.location.pathname;
  navLinks.forEach(function(link) {
    const href = link.getAttribute('href');
    
    // Clear any previously set styles
    link.classList.remove('active');
    link.style.color = '';
    
    // Active state detection for route-based links
    if (href && !href.startsWith('#')) {
      if (currentPath === href || 
          (currentPath === '/' && href.includes('index')) ||
          (href.includes(currentPath) && currentPath !== '/')) {
        link.classList.add('active');
        link.style.color = '#28a745'; // Bootstrap green color
      }else{
        
      }  
    }
  });

  /**
   * Smooth scroll for hash links (About, etc.)
   */
  document.querySelectorAll('a[href^="#"]').forEach(function(link) {
    if (link.getAttribute('href') === '#') return; // Skip generic # links
    
    link.addEventListener('click', function(e) {
      const targetId = this.getAttribute('href');
      const targetElement = document.querySelector(targetId);
      
      if (targetElement) {
        e.preventDefault();
        const offset = 100; // Adjust offset as needed for your header height
        window.scrollTo({
          top: targetElement.offsetTop - offset,
          behavior: 'smooth'
        });
      }
    });
  });

  /**
   * Scroll position detection for on-page sections
   */
  const sections = document.querySelectorAll('section[id]');
  if (sections.length > 0) {
    window.addEventListener('scroll', function() {
      const scrollPosition = window.scrollY + 200;
      
      sections.forEach(function(section) {
        const sectionId = '#' + section.getAttribute('id');
        const link = document.querySelector(`a[href="${sectionId}"]`);
        
        if (link && scrollPosition >= section.offsetTop && 
            scrollPosition <= (section.offsetTop + section.offsetHeight)) {
          // Remove active class from all hash links
          document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.classList.remove('active');
            a.style.color = '';
          });
          
          // Add active class to current section link
          link.classList.add('active');
          link.style.color = '#28a745';
        }
      });
    });
  }
});


/*Search bar functionality*/ 
// Wait for the document to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
  // Toggle advanced search options
  const advancedSearchToggles = document.querySelectorAll('[id^="toggle-advanced"]');
  
  advancedSearchToggles.forEach(toggle => {
      toggle.addEventListener('click', function(e) {
          e.preventDefault();
          
          // Find the closest form and then find the advanced container within it
          const form = this.closest('form');
          const advancedContainer = form.querySelector('.advanced-search-container');
          
          if (advancedContainer) {
              // Toggle visibility
              if (advancedContainer.style.display === 'none' || !advancedContainer.style.display) {
                  advancedContainer.style.display = 'block';
                  this.innerHTML = 'Simple Search <i class="fas fa-chevron-up"></i>';
              } else {
                  advancedContainer.style.display = 'none';
                  this.innerHTML = 'Advanced Search <i class="fas fa-chevron-down"></i>';
              }
          }
      });
  });
  
  // Update sport icon when selection changes
  const sportDropdowns = document.querySelectorAll('.sport-dropdown');
  
  sportDropdowns.forEach(dropdown => {
      dropdown.addEventListener('change', function() {
          const selectedSport = this.value;
          const iconContainer = this.closest('.search-input-group').querySelector('.input-icon');
          
          if (!iconContainer) return;
          
          // Remove all existing fa-* classes
          iconContainer.classList.forEach(className => {
              if (className.startsWith('fa-') && className !== 'fa-basketball-ball') {
                  iconContainer.classList.remove(className);
              }
          });
          
          // Add the appropriate icon class based on selection
          switch (selectedSport) {
              case 'Football':
                  iconContainer.classList.add('fa-futbol');
                  break;
              case 'Basketball':
                  iconContainer.classList.add('fa-basketball-ball');
                  break;
              case 'Tennis':
                  iconContainer.classList.add('fa-table-tennis');
                  break;
              case 'Volleyball':
                  iconContainer.classList.add('fa-volleyball-ball');
                  break;
              case 'Futsal':
                  iconContainer.classList.add('fa-running');
                  break;
              default:
                  iconContainer.classList.add('fa-basketball-ball');  // Default icon
          }
      });
  });
  
  // Pre-select values from URL parameters if they exist
  const urlParams = new URLSearchParams(window.location.search);
  
  // Helper function to set form values from URL parameters
  function setFormValuesFromParams(formId) {
      const form = document.getElementById(formId);
      if (!form) return;
      
      // Set field values based on URL parameters
      for (const [key, value] of urlParams.entries()) {
          const field = form.elements[key];
          if (field) {
              field.value = value;
              
              // Trigger change event for dropdowns that need icon updates
              if (key === 'type' && field.classList.contains('sport-dropdown')) {
                  const event = new Event('change');
                  field.dispatchEvent(event);
              }
          }
      }
      
      // Show advanced search if any advanced fields were used
      const advancedFields = ['size', 'fees', 'is_covered'];
      const hasAdvancedSearch = advancedFields.some(field => urlParams.has(field));
      
      if (hasAdvancedSearch) {
          const advancedToggle = form.querySelector('[id^="toggle-advanced"]');
          const advancedContainer = form.querySelector('.advanced-search-container');
          
          if (advancedToggle && advancedContainer) {
              advancedContainer.style.display = 'block';
              advancedToggle.innerHTML = 'Simple Search <i class="fas fa-chevron-up"></i>';
          }
      }
  }
  
  // Set values for both search forms
  setFormValuesFromParams('field-search-form');
  setFormValuesFromParams('field-search-form-2');
});
  // Toggle Advanced Search on second carousel slide
  const toggleAdvanced2 = document.getElementById('toggle-advanced-2');
  if (toggleAdvanced2) {
      toggleAdvanced2.addEventListener('click', function(e) {
          e.preventDefault();
          const advancedContainer = this.closest('form').querySelector('.advanced-search-container');
          if (advancedContainer) {
              if (advancedContainer.style.display === 'none') {
                  advancedContainer.style.display = 'block';
                  this.classList.add('active');
              } else {
                  advancedContainer.style.display = 'none';
                  this.classList.remove('active');
              }
          }
      });
  }
  
  // Change sport icon when sport is selected
  const sportDropdowns = document.querySelectorAll('.sport-dropdown');
  sportDropdowns.forEach(dropdown => {
      dropdown.addEventListener('change', function() {
          const selectedOption = this.options[this.selectedIndex];
          const iconName = selectedOption.getAttribute('data-icon');
          const iconElement = this.parentElement.querySelector('.input-icon');
          
          if (iconElement && iconName) {
              // Remove all existing classes except fa/fas
              iconElement.className = 'fas input-icon';
              // Add the new icon class
              iconElement.classList.add('fa-' + iconName);
          }
      });
  });


  // JavaScript for custom scroll controls
document.addEventListener('DOMContentLoaded', function() {
  const fieldList = document.querySelector('.field-recommendation-list');
  const scrollUpBtn = document.getElementById('scrollUp');
  const scrollDownBtn = document.getElementById('scrollDown');
  
  if (fieldList && scrollUpBtn && scrollDownBtn) {
      // Initially check if scroll is needed
      checkScrollability();
      
      // Scroll amount for each click (can be adjusted as needed)
      const scrollAmount = 120; // Height of one card
      
      // Scroll up button click event
      scrollUpBtn.addEventListener('click', function() {
          fieldList.scrollBy({
              top: -scrollAmount,
              behavior: 'smooth'
          });
      });
      
      // Scroll down button click event
      scrollDownBtn.addEventListener('click', function() {
          fieldList.scrollBy({
              top: scrollAmount,
              behavior: 'smooth'
          });
      });
      
      // Check if scrolling is possible and update button visibility
      function checkScrollability() {
          // Hide up button if already at the top
          if (fieldList.scrollTop <= 0) {
              scrollUpBtn.classList.add('disabled');
          } else {
              scrollUpBtn.classList.remove('disabled');
          }
          
          // Hide down button if already at the bottom
          if (fieldList.scrollHeight <= fieldList.clientHeight + fieldList.scrollTop) {
              scrollDownBtn.classList.add('disabled');
          } else {
              scrollDownBtn.classList.remove('disabled');
          }
      }
      
      // Update button states when scrolling
      fieldList.addEventListener('scroll', checkScrollability);
      
      // Update on window resize
      window.addEventListener('resize', checkScrollability);
  }
});
