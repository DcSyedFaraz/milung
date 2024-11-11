// src/mixins/draftMixin.js
import _ from 'lodash';

export default {
    props: {
        draftKey: {
            type: String,
            required: true,
        },
        initialData: {
            type: Object,
            default: () => ({}),
        },
        mode: {
            type: String,
            default: 'create', // 'create' or 'edit'
        },
        recordId: {
            type: [String, Number],
            default: null,
        },
    },
    data() {
        return {
            draftData: JSON.parse(JSON.stringify(this.initialData)),
            debouncedSaveDraft: null,
        };
    },
    created() {
        if (this.mode != 'edit') {

            const uniqueDraftKey = this.generateDraftKey();
            console.log(uniqueDraftKey);

            // Initialize the debounced save function
            this.debouncedSaveDraft = _.debounce(() => this.saveDraft(uniqueDraftKey), 500);        // Watch for changes in draftData and trigger debounced save
            this.$watch(
                'draftData',
                () => {
                    this.debouncedSaveDraft();
                },
                { deep: true }
            );

            // Load draft data if available
            this.loadDraft(uniqueDraftKey);
        }
        // Generate a unique draft key based on mode and recordId
    },
    methods: {
        /**
         * Generates a unique key for storing drafts in localStorage.
         */
        generateDraftKey() {
            if (this.mode === 'edit') {
                return `${this.draftKey}_edit`;
            }
            return `${this.draftKey}_create`;
        },

        /**
         * Saves the current draft data to localStorage.
         * @param {String} key - The unique key for localStorage.
         */
        saveDraft(key) {
            const dataToSave = JSON.stringify(this.draftData);
            localStorage.setItem(key, dataToSave);
            console.log(`Draft saved under key: ${key}`);
        },

        /**
         * Loads draft data from localStorage if available.
         * @param {String} key - The unique key for localStorage.
         */
        loadDraft(key) {
            const savedDraft = localStorage.getItem(key);
            if (savedDraft) {
                try {
                    this.draftData = JSON.parse(savedDraft);
                    console.log(`Draft loaded from key: ${key}`);
                    // Optionally, notify the user that a draft was loaded
                    // toastr.info('Loaded saved draft');
                } catch (error) {
                    console.error('Error parsing draft data:', error);
                }
            }
        },

        /**
         * Clears the draft data from localStorage.
         * @param {String} key - The unique key for localStorage.
         */
        clearDraft(key) {
            localStorage.removeItem(key);
            console.log(`Draft cleared for key: ${key}`);
        },
    },
    beforeDestroy() {
        // Optionally, save the draft when the component is about to be destroyed
        const uniqueDraftKey = this.generateDraftKey();
        this.saveDraft(uniqueDraftKey);
    },
};
