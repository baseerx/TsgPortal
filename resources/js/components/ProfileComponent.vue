<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{name}}</div>

                    <div class="card-body">
                        This section would keep Trainees related details
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
                name: "Trainee Profile"
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
