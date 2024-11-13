
Vue.component('task-list', {
    template: `
        <div clas="row">

            <h4>Task list</h4>

            <div class="col-12 col-md-6 offset-md-3 col-xl-4 offset-xl-4">
                Worked today <strong>{{ formatDuration(data.total) }}</strong>
            </div>

            <div v-for="item in data.tasks" class="col-12 col-md-6 offset-md-3 col-xl-4 offset-xl-4 border border-primary mt-2">

                <div class="d-flex justify-content-between px-2 py-1 border-1 text-start">
                    <div class="flex-grow-1 px-2"><strong>{{ item.task.name }}</strong></div>
                    <div class="align-self-center px-2"><strong>{{ formatDuration(item.total) }}</strong></div>
                </div>

                <div v-for="taskTime in item.task.taskTimes" class="d-flex justify-content-between px-2 py-1 border-1 text-start">
                    <div class="px-2">{{ taskTime.start_at }}</div>
                    <div class="align-self-center px-2">{{ taskTime.end_at || '-' }}</div>
                    <div class="align-self-center px-2">{{ taskTime.end_at ? formatDuration(taskTime.duration) : 'Working' }}</div>
                </div>

            </div>
        </div>`,
    props: {
        data: {
            type: Object,
            required: true
        }
    },
    methods: {
        padNum(num){
            return num.toString().padStart(2, '0');
        },
        formatDuration(seconds) {
            if (seconds == 0)
                return 'Not registered';
            let h = Math.floor(seconds / 3600);
            let m = Math.floor((seconds % 3600) / 60);
            let s = seconds % 60;
            return [
                (h ? this.padNum(h)+'h':''),
                (m ? this.padNum(m)+'m':''),
                (s ? this.padNum(s)+'s':''),
            ].join(" ");
        }
    }
});
