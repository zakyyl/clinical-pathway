/**
 * HIV Pathway Manager
 * Manages the HIV clinical pathway interface
 */
const HIVPathway = (function() {
    'use strict';

    // Private variables
    let config = {
        findPatientUrl: '',
        csrfToken: ''
    };
    
    let state = {
        patientFound: false
    };

    // DOM Elements Cache
    const elements = {
        modal: null,
        noRmInput: null,
        dataPasien: null,
        alertBox: null,
        btnSubmit: null,
        btnCari: null,
        searchIcon: null,
        searchText: null,
        submitIcon: null,
        submitText: null
    };

    /**
     * Initialize the module
     */
    function init(userConfig) {
        config = { ...config, ...userConfig };
        cacheElements();
        attachEventListeners();
    }

    /**
     * Cache DOM elements
     */
    function cacheElements() {
        elements.modal = document.getElementById('modalTambah');
        elements.noRmInput = document.getElementById('no_rm');
        elements.dataPasien = document.getElementById('dataPasien');
        elements.alertBox = document.getElementById('alertBox');
        elements.btnSubmit = document.getElementById('btnSubmit');
        elements.btnCari = document.getElementById('btnCari');
        elements.searchIcon = document.getElementById('searchIcon');
        elements.searchText = document.getElementById('searchText');
        elements.submitIcon = document.getElementById('submitIcon');
        elements.submitText = document.getElementById('submitText');
    }

    /**
     * Attach event listeners
     */
    function attachEventListeners() {
        // Escape key to close modal
        document.addEventListener('keydown', handleEscapeKey);

        // Enter key on search input
        if (elements.noRmInput) {
            elements.noRmInput.addEventListener('keypress', handleEnterKey);
        }
    }

    /**
     * Handle Escape key press
     */
    function handleEscapeKey(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    }

    /**
     * Handle Enter key press on search input
     */
    function handleEnterKey(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            cariPasien();
        }
    }

    /**
     * Open modal
     */
    function openModal() {
        if (!elements.modal) return;
        
        elements.modal.classList.add('show');
        document.body.style.overflow = 'hidden';
        resetModal();
    }

    /**
     * Close modal
     */
    function closeModal() {
        if (!elements.modal) return;
        
        elements.modal.classList.remove('show');
        document.body.style.overflow = 'auto';
        resetModal();
    }

    /**
     * Reset modal to initial state
     */
    function resetModal() {
        if (elements.noRmInput) elements.noRmInput.value = '';
        if (elements.dataPasien) elements.dataPasien.classList.remove('show');
        if (elements.alertBox) elements.alertBox.style.display = 'none';
        if (elements.btnSubmit) elements.btnSubmit.disabled = true;
        
        state.patientFound = false;
    }

    /**
     * Handle backdrop click
     */
    function handleBackdropClick(event) {
        if (event.target.id === 'modalTambah') {
            closeModal();
        }
    }

    /**
     * Show alert message
     */
    function showAlert(message, type = 'error') {
        if (!elements.alertBox) return;

        const icon = type === 'success' ? '✅' : '⚠️';
        elements.alertBox.className = `alert alert-${type}`;
        elements.alertBox.innerHTML = `<span>${icon}</span><span>${message}</span>`;
        elements.alertBox.style.display = 'flex';
        
        setTimeout(() => {
            elements.alertBox.style.display = 'none';
        }, 5000);
    }

    /**
     * Set loading state for button
     */
    function setButtonLoading(button, iconElement, textElement, isLoading, loadingText, normalText, normalIcon) {
        if (!button || !iconElement || !textElement) return;

        button.disabled = isLoading;
        
        if (isLoading) {
            iconElement.innerHTML = '<span class="spinner"></span>';
            textElement.textContent = loadingText;
        } else {
            iconElement.textContent = normalIcon;
            textElement.textContent = normalText;
        }
    }

    /**
     * Fill patient data in display grid
     */
    function fillPatientData(data) {
        const fields = {
            'display_no_rawat': data.no_rawat,
            'display_nama_pasien': data.nama_pasien,
            'display_jk': data.jk,
            'display_usia': data.usia ? `${data.usia} tahun` : '-',
            'display_tgl_masuk': data.tgl_masuk || '-',
            'display_tgl_keluar': data.tgl_keluar || '-',
            'display_lama_rawat': data.lama_rawat ? `${data.lama_rawat} hari` : '-',
            'display_diagnosa_awal': data.diagnosa_awal || '-',
            'display_kelas': data.kelas || '-',
            'display_rujukan': data.rujukan || '-'
        };

        // Fill display fields
        Object.entries(fields).forEach(([elementId, value]) => {
            const element = document.getElementById(elementId);
            if (element) {
                element.textContent = value;
            }
        });

        // Fill hidden inputs
        const noRawatInput = document.getElementById('no_rawat');
        const namaPasienInput = document.getElementById('nama_pasien');
        
        if (noRawatInput) noRawatInput.value = data.no_rawat;
        if (namaPasienInput) namaPasienInput.value = data.nama_pasien;
    }

    /**
     * Search for patient
     */
    async function cariPasien() {
        const noRm = elements.noRmInput?.value.trim();
        
        if (!noRm) {
            showAlert('Silakan masukkan No. RM terlebih dahulu', 'error');
            return;
        }

        // Set loading state
        setButtonLoading(
            elements.btnCari,
            elements.searchIcon,
            elements.searchText,
            true,
            'Mencari...',
            'Cari Pasien',
            '🔍'
        );

        try {
            const response = await fetch(config.findPatientUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': config.csrfToken
                },
                body: JSON.stringify({ no_rm: noRm })
            });

            const result = await response.json();

            if (result.status) {
                fillPatientData(result.data);
                
                // Show data grid and enable submit
                if (elements.dataPasien) elements.dataPasien.classList.add('show');
                if (elements.btnSubmit) elements.btnSubmit.disabled = false;
                
                state.patientFound = true;
                showAlert('Data pasien berhasil ditemukan!', 'success');
            } else {
                // Hide data grid and disable submit
                if (elements.dataPasien) elements.dataPasien.classList.remove('show');
                if (elements.btnSubmit) elements.btnSubmit.disabled = true;
                
                state.patientFound = false;
                showAlert(result.message || 'Pasien tidak ditemukan', 'error');
            }
        } catch (error) {
            console.error('Error searching patient:', error);
            showAlert('Terjadi kesalahan saat mencari data', 'error');
        } finally {
            // Reset button state
            setButtonLoading(
                elements.btnCari,
                elements.searchIcon,
                elements.searchText,
                false,
                'Mencari...',
                'Cari Pasien',
                '🔍'
            );
        }
    }

    /**
     * Handle form submission
     */
    function handleSubmit(event) {
        if (!state.patientFound) {
            event.preventDefault();
            showAlert('Silakan cari data pasien terlebih dahulu', 'error');
            return false;
        }

        // Set loading state
        setButtonLoading(
            elements.btnSubmit,
            elements.submitIcon,
            elements.submitText,
            true,
            'Menyimpan...',
            'Simpan Data',
            '💾'
        );

        return true;
    }

    // Public API
    return {
        init,
        openModal,
        closeModal,
        handleBackdropClick,
        cariPasien,
        handleSubmit
    };
})();

// Make it available globally
window.HIVPathway = HIVPathway;