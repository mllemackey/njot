const state = {
    users: [],
    userEvents: [],
    userNotifications: []
}

const getters = {
    users: state => {
        return state.users
    },
    userEvents: state => {
        return state.userEvents
    },
    userNotifications: state => {
        return state.userNotifications
    }
}
const mutations = {
    setUsers: (state, payload) => {
        state.users = payload
    },
    setUserEvents: (state, payload) => {
        state.userEvents = payload
    },
    setUserNotifications: (state, payload) => {
        state.userNotifications = payload
    }
}

const actions = {
    getUsers: ({commit}) => {
        return new Promise((resolve, reject) => {
            axios.get('users').then(response => {
                commit('setUsers', response.data)
                resolve(response)
            }).catch(error => {
                reject(error)
            })
        })
    },
    getUserEvents: ({dispatch, commit}) => {
        return new Promise((resolve, reject) => {
            axios.get('me/events').then(response => {
                commit('setUserEvents', response.data.data)

                resolve(response.data.data)
            }).catch(error => {
                reject(error)
            })
        });
    },
    getUserNotifications: ({dispatch, commit}) => {
        return new Promise((resolve, reject) => {
            axios.get('me/notifications').then(response => {

                commit('setUserNotifications', response.data.data)

                resolve(response.data.data)
            }).catch(error => {
                reject(error)
            })
        });
    },
    markAllUsersNotificationsRead: ({dispatch, commit}, payload) => {
        return new Promise((resolve, reject) => {
            axios.put('notifications/read-all', payload.data ).then(response => {
                commit('setUserNotifications', response.data.data)

                resolve(response.data.data)
            }).catch(error => {
                reject(error)
            })
        });
    },
    markUsersNotificationRead: ({dispatch, commit}, payload) => {
        return new Promise((resolve, reject) => {
            axios.put('notifications/' + payload.id + '/read', payload.data ).then(response => {
                commit('setUserNotifications', response.data.data)

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
