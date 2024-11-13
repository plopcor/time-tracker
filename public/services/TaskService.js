const taskService = {
    startTask(name) {
        return axios.post('/api/task/start', { name });
    },
    stopTask(name) {
        return axios.post('/api/task/stop', { name })
    },
    getTodayResume() {
        return axios.get('/api/tasks/today').then(res => res.data);
    }
}
