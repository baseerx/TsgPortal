<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{this.name}}</h4>

            </div>
            <div class="card-body">
                <form @submit="submitAssets">
                    <div class="form-group row">
                        <div class="col-2 text-right"><label>Company Name</label></div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" id="leasingcompany" name="leasingcompany"
                                   type="text" v-model="form.name">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="col-2 text-right"><label>Description</label></div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('description') }" class="form-control" id="description" name="description"
                                   type="text" v-model="form.description">
                            <has-error :form="form" field="description"></has-error>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-primary" id="submitBtn" name="submitBtn" type="submit"
                                v-text="btnName"></button>
                    </div>
                    <alert-error :form="form" message="Fill all the fields correctly.."></alert-error>
                </form>
              <LeasingCompanyTable @updaterecord="updateRecord" :randno="passrandNo"></LeasingCompanyTable>
            </div>
        </div>
    </div>
</template>

<script>
    import LeasingCompanyTable from "./LeasingCompanyTable";
    export default {
        components:{
            LeasingCompanyTable
        },
        data() {
            return {
                form: new Form({
                    name: '',
                    description: '',
                }),
                name: "Define Leasing Company Name",
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
                   this.form.put('api/leasingcompany/'+this.updateId)
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
                    this.form.post('api/leasingcompany')
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
                axios.get('api/leasingcompany/'+id)
                    .then(response=>this.form.fill(response.data))
                    .catch(error=>swal('Failed!','Record Cant be fetched..','error'));
            }
        }

    }
</script>

<style scoped>

</style>
