
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Time tracker</title>

        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

        <!-- Vue 2 - Development -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script> -->
        <!-- Vue 2 - Production -->
        <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
        <!-- Axios -->
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

        <!-- Styles -->
        <style>

        </style>

        <!-- Vue components -->
        <script src="./components/TaskRegistration.js"></script>
        <script src="./components/TaskList.js"></script>
        <script src="./services/TaskService.js"></script>

    </head>
    <body>
        <div id="app">

            <div class="container-fluid text-center">

                <div class="row">
                    <h1>Time tracker</h1>
                </div>

                <br>

                <!-- Task input -->
                <task-control @task-started="getTodayResume" @task-stopped="getTodayResume"></task-control>

                <br>

                <!-- Task list -->
                <task-list :data="data"></task-list>

            </div>
        </div>

        <script>
            new Vue({
                el: '#app',
                data: {
                    data: {}
                },
                methods: {
                    getTodayResume() {
                        taskService.getTodayResume().then(res => {
                            this.data = res;
                        })
                    }
                },
                created() {
                    this.getTodayResume();
                }
            });
        </script>

    </body>
</html>
