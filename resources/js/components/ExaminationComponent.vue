<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header h5">{{name}}</div>

                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Examination</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Instructor can create multiple exam like mid and final(but these will be optional)
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>One Time Exam,Mcqs based online exam conduction</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>handouts can be provided to users</td>

                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-muted">
                        <router-link to="/home">
                            <i class="fa fa-arrow-left fa-3x text-primary"></i>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: "Exam Section"
            }
        },
        mounted() {

        }
    }
</script>
