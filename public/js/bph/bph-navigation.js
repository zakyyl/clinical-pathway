/**
 * ============================================
 * BPH CLINICAL PATHWAY - TAB NAVIGATION
 * ============================================
 */

document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content-item');
    const btnPrevious = document.getElementById('btnPrevious');
    const btnNext = document.getElementById('btnNext');
    const btnSubmit = document.getElementById('btnSubmit');
    const progressFill = document.getElementById('progressFill');
    const currentStepEl = document.getElementById('currentStep');
    const totalSteps = tabButtons.length;
    
    let currentTabIndex = 0;
    let maxUnlockedTab = 0;

    // Initialize
    updateButtonsAndProgress();

    // Tab button click handlers
    tabButtons.forEach((button, index) => {
        button.addEventListener('click', function() {
            if (!this.disabled) {
                switchToTab(index);
            }
        });
    });

    // Previous button handler
    btnPrevious.addEventListener('click', function() {
        if (currentTabIndex > 0) {
            switchToTab(currentTabIndex - 1);
        }
    });

    // Next button handler
    btnNext.addEventListener('click', function() {
        if (currentTabIndex < totalSteps - 1) {
            // Mark current tab as completed
            tabButtons[currentTabIndex].classList.add('completed');
            
            // Unlock next tab if it hasn't been unlocked yet
            if (currentTabIndex + 1 > maxUnlockedTab) {
                maxUnlockedTab = currentTabIndex + 1;
                tabButtons[maxUnlockedTab].disabled = false;
            }
            
            // Switch to next tab
            switchToTab(currentTabIndex + 1);
        }
    });

    /**
     * Switch to specific tab
     */
    function switchToTab(index) {
        // Remove active class from all tabs
        tabButtons.forEach(btn => btn.classList.remove('active'));
        tabContents.forEach(content => content.classList.remove('active'));
        
        // Add active class to selected tab
        tabButtons[index].classList.add('active');
        tabContents[index].classList.add('active');
        
        // Update current tab index
        currentTabIndex = index;
        
        // Update buttons and progress
        updateButtonsAndProgress();
        
        // Scroll to tabs content
        scrollToContent();
    }

    /**
     * Update navigation buttons and progress bar
     */
    function updateButtonsAndProgress() {
        // Update progress bar
        const progress = ((currentTabIndex + 1) / totalSteps) * 100;
        progressFill.style.width = progress + '%';
        currentStepEl.textContent = currentTabIndex + 1;
        
        // Show/hide Previous button
        if (currentTabIndex === 0) {
            btnPrevious.style.display = 'none';
        } else {
            btnPrevious.style.display = 'flex';
        }
        
        // Show/hide Next and Submit buttons
        if (currentTabIndex === totalSteps - 1) {
            btnNext.style.display = 'none';
            btnSubmit.style.display = 'flex';
        } else {
            btnNext.style.display = 'flex';
            btnSubmit.style.display = 'none';
        }
    }

    /**
     * Scroll to tabs content area
     */
    function scrollToContent() {
        const tabsContent = document.querySelector('.tabs-content');
        if (tabsContent) {
            const offset = 20;
            const elementPosition = tabsContent.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - offset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }
    }

    /**
     * Keyboard navigation
     */
    document.addEventListener('keydown', function(e) {
        // Alt + Arrow Right = Next tab
        if (e.altKey && e.key === 'ArrowRight') {
            e.preventDefault();
            if (currentTabIndex < totalSteps - 1 && !tabButtons[currentTabIndex + 1].disabled) {
                btnNext.click();
            }
        }
        
        // Alt + Arrow Left = Previous tab
        if (e.altKey && e.key === 'ArrowLeft') {
            e.preventDefault();
            if (currentTabIndex > 0) {
                btnPrevious.click();
            }
        }
    });

    /**
     * Save progress to localStorage
     */
    function saveProgress() {
        const progress = {
            currentTab: currentTabIndex,
            maxUnlockedTab: maxUnlockedTab,
            completedTabs: []
        };

        tabButtons.forEach((btn, index) => {
            if (btn.classList.contains('completed')) {
                progress.completedTabs.push(index);
            }
        });

        localStorage.setItem('bph_form_progress', JSON.stringify(progress));
    }

    /**
     * Load progress from localStorage
     */
    function loadProgress() {
        const savedProgress = localStorage.getItem('bph_form_progress');
        if (savedProgress) {
            try {
                const progress = JSON.parse(savedProgress);
                
                // Restore max unlocked tab
                maxUnlockedTab = progress.maxUnlockedTab || 0;
                
                // Unlock all tabs up to max
                for (let i = 0; i <= maxUnlockedTab; i++) {
                    tabButtons[i].disabled = false;
                }
                
                // Restore completed tabs
                if (progress.completedTabs) {
                    progress.completedTabs.forEach(index => {
                        tabButtons[index].classList.add('completed');
                    });
                }
            } catch (e) {
                console.error('Error loading progress:', e);
            }
        }
    }

    /**
     * Clear progress from localStorage
     */
    function clearProgress() {
        localStorage.removeItem('bph_form_progress');
    }

    // Auto-save progress on tab change
    const originalSwitchToTab = switchToTab;
    switchToTab = function(index) {
        originalSwitchToTab(index);
        saveProgress();
    };

    // Load saved progress on page load
    // loadProgress(); // Uncomment to enable auto-save feature

    // Clear progress on form submit
    const form = document.getElementById('bphForm');
    if (form) {
        form.addEventListener('submit', function() {
            clearProgress();
        });
    }

    // Expose functions globally for debugging
    window.bphFormNavigation = {
        switchToTab: switchToTab,
        getCurrentTab: () => currentTabIndex,
        getMaxUnlockedTab: () => maxUnlockedTab,
        saveProgress: saveProgress,
        loadProgress: loadProgress,
        clearProgress: clearProgress
    };

    console.log('✅ BPH Form Navigation initialized');
    console.log('💡 Keyboard shortcuts: Alt+← (Previous) | Alt+→ (Next)');
});
