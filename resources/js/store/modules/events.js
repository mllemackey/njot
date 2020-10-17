const state = {
    loader: true,
    events: [],
    event: {},
    eventUsers: []
}

const getters = {
    loader: state => {
        return state.loader;
    },
    events: state => {
        return state.events
    },
    event: state => {
        return state.event
    },
    publicEvents: state => {
        return state.events.filter(event => event.data.privacy == 1)
    },
    eventUsers: state => {
        return state.event.data.users
    },
    eventsPresentIdeas: state => {
        return state.event.data.presentIdeas
    },
}
const mutations = {
    updateLoader: (state, payload) => {
        state.loader = payload;
    },
    setEvents: (state, payload) => {
        state.events = payload
    },
    setEvent: (state, payload) => {
        state.event = payload
    },
    setEventUsers: (state, payload) => {
        state.eventUsers = payload
    }
}

const actions = {
    setLoader: ({commit}, payload) => {
        commit('updateLoader', payload);
    },
    getEvents: ({commit}) => {
        return new Promise((resolve, reject) => {
            axios.get('events').then(response => {
                commit('setEvents', response.data.data)
                commit('updateLoader', false)
                resolve(response)
            }).catch(error => {
                reject(error)
            })
        })
    },
    getEvent: ({dispatch, commit}, payload) => {
        return new Promise((resolve, reject) => {
            axios.get('events/' + payload).then(response => {
                commit('updateLoader', false)
                commit('setEvent', response.data)

                resolve(response.data.data)
            }).catch(error => {
                commit('updateLoader', false)
                reject(error)
            })
        });
    },
    addEventUsers: ({dispatch, commit}, payload) => {
        return new Promise((resolve, reject) => {
            axios.post('events/' + payload.id + '/users', payload.data ).then(response => {
                commit('setEvent', response.data)

                resolve(response.data.data)
            }).catch(error => {
                reject(error)
            })
        });
    },
    deleteEventUsers: ({dispatch, commit}, payload) => {
        return new Promise((resolve, reject) => {
            axios.put('events/' + payload.id + '/users', payload.data ).then(response => {
                commit('setEvent', response.data)

                resolve(response.data.data)
            }).catch(error => {
                reject(error)
            })
        });
    },
    createEvent: ({commit, dispatch}, payload) => {
        return new Promise((resolve, reject) => {
            axios.post('events', payload, {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            })
                .then(response => {
                    this.$router.push(response.data.links.self)
                })
                .catch(errors => {

                });
        });
    },
}

export default {
    state,
    mutations,
    actions,
    getters
}
