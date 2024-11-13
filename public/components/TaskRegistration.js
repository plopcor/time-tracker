
Vue.component('task-control', {
    template: `
    <div class="row justify-center">

        <h4>Register work</h4>

        <div class="col-12 col-md-6 offset-md-3 col-xl-4 offset-xl-4">

            <div class="input-group">
                <input type="text"
                       class="form-control"
                       name="task"
                       v-model.trim="name"
                       placeholder="Enter a task name"
                       @keyup.enter="startTask"
                       :disabled="isStarted"
                >
                <button v-if="!isStarted" @click="startTask" class="btn btn-success" type="button" :disabled="isWorking">Start</button>
                <button v-else @click="stopTask" class="btn btn-danger" type="button" :disabled="isWorking">Stop</button>
            </div>
            <div>Working for <strong>{{ timePassed }}</strong></div>

        </div>
    </div>`,
    data() {
        return {
            name: "",
            isWorking: false,
            isStarted: false,
            timer: null,
            timerSeconds: 0
        };
    },
    computed: {
        timePassed() {
            if (this.timerSeconds == 0) {
                return '00h 00m 00s';
            }
            let h = Math.floor(this.timerSeconds / 3600);
            let m = Math.floor((this.timerSeconds % 3600) / 60);
            let s = this.timerSeconds % 60;
            return `${this.padNum(h)}h ${this.padNum(m)}m ${this.padNum(s)}s`;
        }
    },
    methods: {
        padNum(num){
            return num.toString().padStart(2, '0');
        },
        startTask() {
            if (!this.name) {
                alert('Task name is empty')
                return;
            }
            if (this.isStarted)
                return;

            this.timerSeconds = 0;
            this.isWorking = true;

            taskService.startTask(this.name).then(res => {
                this.isStarted = true;
                this.timer = setInterval(() => {
                    this.timerSeconds++;
                }, 1000);

                this.$emit('task-started', res);

            }).catch(err => alert('Error starting task'))
                .finally(() => this.isWorking = false)
        },
        stopTask() {
            this.isWorking = true;
            taskService.stopTask(this.name).then(res => {
                clearInterval(this.timer);
                this.timer = null;
                this.isStarted = false;

                this.$emit('task-stopped', res)

            }).catch(err => alert('Error stopping task'))
                .finally(() => this.isWorking = false)
        }
    }
});
