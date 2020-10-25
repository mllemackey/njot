const state = {
    presentIdeas: [],
}

const getters = {
    presentIdeas: state => {
        return state.presentIdeas
    }
}
const mutations = {
    addPresentIdea: (state, payload) => {
        state.presentIdeas = [...state.presentIdeas, payload]
    },
    setPresentIdea: (state, payload) => {
        state.presentIdeas.find( p => p.id === payload.id)
    },
    setPresentIdeas: (state, payload) => {
        state.presentIdeas = payload
    },
    updatePresentIdea: (state, payload) => {
        state.presentIdeas = state.presentIdeas.map(presentIdea => {
            if(presentIdea.id === payload.id) {
                return payload
            }
            return presentIdea
        })
    },
    deletePresentIdea: (state, payload) => {
        state.presentIdeas = state.presentIdeas.filter(presentIdea => {
            return presentIdea.id !== payload
        })
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
    createPresentIdea: ({commit, dispatch}, payload) => {
        return new Promise((resolve, reject) => {
            axios.post('present-ideas', payload)
                .then(response => {
                    commit('addPresentIdea', response.data.data)
                    resolve(response)
                })
                .catch(errors => {

                });
        });
    },
    editPresentIdea: ({dispatch, commit}, payload) => {
        return new Promise((resolve, reject) => {
            axios.put('present-ideas/' + payload.present_idea_id, payload.data ).then(response => {
                commit('updatePresentIdea', response.data.data)

                resolve(response.data.data)
            }).catch(error => {
                reject(error)
            })
        });
    },
    deletePresentIdea: ({dispatch, commit}, payload) => {
        return new Promise((resolve, reject) => {
            axios.delete('present-ideas/' + payload.present_idea_id ).then(response => {
                commit('deletePresentIdea', payload.present_idea_id)

                resolve(response.data.data)
            }).catch(error => {
                reject(error)
            })
        });
    },
    vote: ({dispatch, commit}, payload) => {
        return new Promise((resolve, reject) => {
            axios.put('present-ideas/' + payload.present_idea_id + '/votes', payload ).then(response => {
                commit('setPresentIdeas', response.data.data)

                resolve(response.data.data)
            }).catch(error => {
                reject(error)
            })
        });
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}
