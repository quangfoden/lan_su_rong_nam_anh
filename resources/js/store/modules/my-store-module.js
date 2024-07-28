const state = {
    availableCountryOpts: [
        { value: 'cambodia', text: '/assets/images/flags/cambodia.jpg' },
        { value: 'china', text: '/assets/images/flags/china.jpg' },
        { value: 'hongkong', text: '/assets/images/flags/hongkong.jpg' },
        { value: 'indonesia', text: '/assets/images/flags/indonesia.jpg' },
        { value: 'korea', text: '/assets/images/flags/korea.jpg' },
        { value: 'laos', text: '/assets/images/flags/laos.jpg' },
        { value: 'malaysia', text: '/assets/images/flags/malaysia.jpg' },
        { value: 'philippines', text: '/assets/images/flags/philippines.jpg' },
        { value: 'russia', text: '/assets/images/flags/russia.jpg' },
        { value: 'singapore', text: '/assets/images/flags/singapore.jpg' },
        { value: 'taiwan', text: '/assets/images/flags/taiwan.jpg' },
        { value: 'thailand', text: '/assets/images/flags/thailand.jpg' },
        { value: 'us', text: '/assets/images/flags/us.jpg' },
        { value: 'vietnam', text: '/assets/images/flags/vietnam.jpg' },
    ]
};
const getters = {
    availableCountryOpts: state => state.availableCountryOpts
};

const actions = {}

const mutations = {
    evaluationTypes: (state, payload) => (state.evaluationTypes = payload),
    cardTypes: (state, payload) => (state.cardTypes = payload),
};

export default {
    state,
    getters,
    actions,
    mutations,
};
