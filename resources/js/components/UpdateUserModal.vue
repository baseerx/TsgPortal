<template>

    <div aria-hidden="true" aria-labelledby="updateUserModalLabel" class="modal fade" id="updatemodal" role="dialog"
         tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Update <span class="text-info">{{this.sendId.name}}</span></h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="updateUser" id="updateform">
                    <div class="modal-body">
                        <div class="form-group">
                            <input :class="{ 'is-invalid': form.errors.has('name') }" autocomplete="off" class="form-control"

                                   name="name" placeholder="Name"
                                   type="text" v-model="form.name">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">
                            <input :class="{ 'is-invalid': form.errors.has('email') }" autocomplete="off" class="form-control"
                                   name="email" placeholder="Email Address"
                                   type="text" v-model="form.email">
                            <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-group">
                            <select :class="{ 'is-invalid': form.errors.has('ttype') }" class="form-control" id="update_ttype" name="ttype"
                                    v-model="form.ttype">
                                <option value="">Select T Type</option>
                                <option value="trainee">Trainee</option>
                                <option value="trainer">Trainer</option>
                            </select>

                            <has-error :form="form" field="ttype"></has-error>
                        </div>
                        <div class="form-group">
                            <select :class="{ 'is-invalid': form.errors.has('usertype') }" class="form-control" id="update_user_type"
                                    name="update_user_type"
                                    v-model="form.usertype">
                                <option value="">User Type</option>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                            <has-error :form="form" field="usertype"></has-error>
                        </div>
                        <div class="form-group">
                            <input :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" name="password"
                                   placeholder="Password"
                                   type="password" v-model="form.password">
                            <has-error :form="form" field="password"></has-error>
                        </div>

                    </div>
                    <div class="modal-footer">

                        <button class="btn btn-danger btn-md" data-dismiss="modal" type="button">Close</button>
                        <button class="btn btn-info btn-md" type="submit">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


</template>

<script>
    export default {
        props: ['sendId'],
        data:function (){
            return {

                form: new Form({
                    name: '',
                    email:'',
                    password: '',
                    usertype: '',
                    ttype: ''
                })


            }
        },
        methods:
            {
                updateUser() {
                    // Submit the form via a POST request
                    this.form.put('api/user/'+this.sendId.id).then(response => {

                        $('#updatemodal').modal('hide');


                        swal("Good job!", "Record Updated Successfully!", "success");

                        })
                        .catch(error => {
                            console.log(error);
                        });

                    this.form.reset();

                },
            }
    }
</script>

<style scoped>

</style>
