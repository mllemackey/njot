const state = {
    // userEvents: [],
    presentIdeas: [],
}

const getters = {
    presentIdeas: state => {
        return state.presentIdeas
    },
    // userEvents: state => {
    //     return state.userEvents
    // }
}
const mutations = {
    // setUserEvents: (state, payload) => {
    //     state.userEvents = payload
    // },
    setPresentIdeas: (state, payload) => {
        state.presentIdeas = payload
    }
}

const actions = {
    getPresentIdeas: ({commit}) => {
        return new Promise((resolve, reject) => {
            axios.get('present-ideas').then(response => {
                commit('setPresentIdeas', response.data.data)
                resolve(response)
            }).catch(error => {
                reject(error)
            })
        })
    },
    // getUserEvents: ({dispatch, commit}) => {
    //     return new Promise((resolve, reject) => {
    //         axios.get('me/events').then(response => {
    //             commit('setUserEvents', response.data.data)
    //
    //             resolve(response.data.data)
    //         }).catch(error => {
    //             reject(error)
    //         })
    //     });
    // },
    addVotes: ({dispatch, commit}, payload) => {
        return new Promise((resolve, reject) => {
            axios.post('present-ideas/' + payload.id + '/votes', payload.data ).then(response => {
                commit('setPresentIdeas', response.data.data)

                resolve(response.data.data)
            }).catch(error => {
                reject(error)
            })
        });
    },
    deleteVotes: ({dispatch, commit}, payload) => {
        return new Promise((resolve, reject) => {
            axios.put('present-ideas/' + payload.id + '/votes', payload.data ).then(response => {
                commit('setPresentIdeas', response.data.data)

                resolve(response.data.data)
            }).catch(error => {
                reject(error)
            })
        });
    },
}

export default {
    state,
    mutations,
    actions,
    getters
}
