const state = {
    userEvents: [],
    users: [],
}

const getters = {
    users: state => {
        return state.users
    },
    userEvents: state => {
        return state.userEvents
    }
}
const mutations = {
    setUserEvents: (state, payload) => {
        state.userEvents = payload
    },
    setUsers: (state, payload) => {
        state.users = payload
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
}

export default {
    state,
    mutations,
    actions,
    getters
}
