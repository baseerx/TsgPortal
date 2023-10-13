<template>
    <div aria-hidden="true" aria-labelledby="resultModalLabel" class="modal" id="resultModal" role="dialog"
         tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-text="modalTitle"></h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="submitResult">
                        <div class="form-group">
                            <label>Email</label>
                            <input :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" name="email"
                                   type="text" v-model="form.email">
                            <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-group">
                            <label>CNIC <span class="text-danger">*</span></label>
                            <input :class="{ 'is-invalid': form.errors.has('cnic') }" class="form-control" name="cnic"
                                   type="text" v-model="form.cnic">
                            <has-error :form="form" field="cnic"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Hris ID</label>
                            <input :class="{ 'is-invalid': form.errors.has('rollno') }" class="form-control"
                                   name="rollno"
                                   type="text" v-model="form.rollno">
                            <has-error :form="form" field="rollno"></has-error>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit">Submit</button>
                            <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['showModal', 'result'],
        data() {
            return {
                form: new Form({
                    email: '',
                    cnic: '',
                    rollno: '',
                    assignResult:0
                }),
                modalTitle: 'Enter Information For Result Retrieval'
            }
        },
        watch: {
            showModal: (val) => val > 0 ? $("#resultModal").modal('show') : $("#resultModal").modal('hide'),
            result(resVal)
            {
                if (resVal !== 0)
                {
                    this.form.assignResult=resVal;
                }
            }
    },
    mounted()
    {
        // console.log(this.result);
    }
    ,
    methods:
    {
        submitResult()
        {
            swal({
                title: "Are you sure?",
                text: "You want to submit Paper after you will not be able to make changes..!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((oK) => {
                    if (oK) {
                       this.form.post('api/submitresult')
                           .then((response)=>{
                               swal('Notice!','Your Result Submitted Successfully..','success');
                               this.form.reset();
                               $("#resultModal").modal('hide');
                               this.$router.push({ path: '/feedback' });
                           })
                           .catch((error)=>swal('Error!','Your Result Submitted Failed..Contact Admin','error'));
                    } else {
                        swal("Kindly fill the paper accordingly..!");
                    }
                });
        }
    }
    }
</script>

<style scoped>

</style>
