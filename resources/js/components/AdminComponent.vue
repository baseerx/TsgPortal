<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header h5 text-success text-center">{{name}}</div>

                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Admin/Instructor</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">1</th>

                                <td>Time table of course will be defined one time.(yearly or monthly)</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>There can different batches</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Admin should be able to communicate message with all participents through portal</td>
                            </tr>
                            <tr>
                                <th scope="row">4</th>
                                <td>Admin should be able to create an exam and print score.He should be able to import
                                    the result as spreadsheet
                                </td>
                            </tr> <tr>
                                <th scope="row">5</th>
                                <td>He should be able to upload books/lectures/videos etc for the whole class or any individual or group for individuals</td>
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
                name: "Administrator/Instructor"
            }
        },
        mounted() {

        }
    }
</script>
