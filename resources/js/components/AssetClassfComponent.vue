<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{this.name}}</h4>

            </div>
            <div class="card-body">
                <form @submit="submitAssets">
                    <div class="form-group row">
                        <div class="col-2 text-right"><label>Asset Classification</label></div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('assetcls') }" class="form-control" id="assetcls" name="assetcls"
                                   type="text" v-model="form.assetcls">
                            <has-error :form="form" field="assetcls"></has-error>
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
              <AssetClassfTable @updaterecord="updateRecord" :randno="passrandNo"></AssetClassfTable>
            </div>
        </div>
    </div>
</template>

<script>
    import AssetClassfTable from "./AssetClassfTable";
    export default {
        components:{
            AssetClassfTable
        },
        data() {
            return {
                form: new Form({
                    assetcls: '',
                    description: '',
                }),
                name: "Define Asset Classification",
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
                   this.form.put('api/assetcls/'+this.updateId)
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
                    this.form.post('api/assetcls')
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
                axios.get('api/assetcls/'+id)
                    .then(response=>this.form.fill(response.data))
                    .catch(error=>swal('Failed!','Record Cant be fetched..','error'));
            }
        }

    }
</script>

<style scoped>

</style>
