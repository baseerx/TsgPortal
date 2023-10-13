<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{this.name}}</h4>

            </div>
            <div class="card-body">
                <form @submit="submitAssets">
                    <div class="form-group row">
                        <div class="col-2"><label>Dep Method Name</label></div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('depmethod') }" class="form-control" id="depmethod" name="depmethod"
                                   type="text" v-model="form.depmethod">
                            <has-error :form="form" field="depmethod"></has-error>
                        </div>
                        <div class="col-2 text-center"><label>Rate</label></div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('rate') }" placeholder="number" class="form-control" id="rate" name="rate"
                                   type="text" v-model="form.rate">
                            <has-error :form="form" field="rate"></has-error>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-primary" id="submitBtn" name="submitBtn" type="submit"
                                v-text="btnName"></button>
                    </div>
                    <div class="my-2">
                        <alert-error :form="form" message="Fill all the fields correctly.."></alert-error>
                    </div>
                </form>
              <DepMethodTable @updaterecord="updateRecord" :randno="passrandNo"></DepMethodTable>
            </div>
        </div>
    </div>
</template>

<script>
    import DepMethodTable from "./DepMethodTable";
    export default {
        components:{
            DepMethodTable
        },
        data() {
            return {
                form: new Form({
                    depmethod: '',
                    rate: '',
                }),
                name: "Define Depreciation Method",
                btnName: 'Submit',
                updateId:0,
                passrandNo:0,
                assetsData:{}
            }
        },
        mounted() {
            Fire.$on('updateTable',()=>{
                this.passrandNo=Math.random();
            });

        },
        watch: {

        },
        methods: {
            submitAssets(e)
            {
                e.preventDefault();
                if (this.updateId>0)
                {
                   this.form.put('api/depmethod/'+this.updateId)
                    .then(reponse=>{
                        swal("Congratulations!","Record Updated Successfully..","success");
                        Fire.$emit('updateTable');
                        this.btnName='Submit';
                        this.form.reset();
                    })
                    .catch(error=>swal("Failed!","Record Updation Failed..","error"))
                }
                else
                {
                    this.form.post('api/depmethod')
                        .then(response=>{
                            swal('Congratulations!','Data Has Been Successfully Submitted..','success');
                            Fire.$emit('updateTable');
                            this.form.reset();
                        })
                        .catch(error=>swal('Failed!','Data Has Been Successfully Submitted..','error'));
                }
            },
            updateRecord(id)
            {
                this.updateId=id;
                this.btnName='Update';
                axios.get('api/depmethod/'+id)
                    .then(response=>this.form.fill(response.data))
                    .catch(error=>swal('Failed!','Record Cant be fetched..','error'));
            }
        }

    }
</script>

<style scoped>

</style>
