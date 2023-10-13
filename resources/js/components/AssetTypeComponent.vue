<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{this.name}}</h4>

            </div>
            <div class="card-body">
                <form @submit="submitAssets">
                    <div class="form-group row py-0 my-0">
                        <div class="col-2 text-right"><label>Asset Type</label></div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('assettype') }" class="form-control" id="assettype" name="assettype"
                                   type="text" v-model="form.assettype">
                            <has-error :form="form" field="assettype"></has-error>
                        </div>
                        <div class="col-2 text-right"><label>Description</label></div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('description') }" class="form-control" id="description" name="description"
                                   type="text" v-model="form.description">
                            <has-error :form="form" field="description"></has-error>
                        </div>
                    </div>
                    <div class="form-group row py-0 my-0">
                        <div class="col-2 text-right"><label>CWIP</label></div>
                        <div class="col-4">
                            <select name="cwip" id="cwip" v-model="form.cwip" :class="{ 'is-invalid': form.errors.has('cwip') }" class="form-control">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                            <has-error :form="form" field="cwip"></has-error>
                        </div>
                        <div class="col-2 text-right"><label>Tangible</label></div>
                        <div class="col-4">
                            <select name="tangible" id="tangible" v-model="form.tangible" :class="{ 'is-invalid': form.errors.has('tangible') }" class="form-control">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                            <has-error :form="form" field="tangible"></has-error>
                        </div>
                    </div>
                    <div class="form-group row py-0 my-0">
                        <div class="col-2 text-right"><label>Stores</label></div>
                        <div class="col-4">
                            <select name="stores" id="stores" v-model="form.stores" :class="{ 'is-invalid': form.errors.has('stores') }" class="form-control">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                            <has-error :form="form" field="stores"></has-error>
                        </div>
                        <div class="col-2 text-right"><label>Others</label></div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('others') }" class="form-control" id="others" name="others"
                                   type="text" v-model="form.others">
                            <has-error :form="form" field="others"></has-error>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-primary" id="submitBtn" name="submitBtn" type="submit"
                                v-text="btnName"></button>
                    </div>
                    <alert-error :form="form" message="Fill all the fields correctly.."></alert-error>
                </form>
              <AssetTypeTable @updaterecord="updateRecord" :randno="passrandNo"></AssetTypeTable>
            </div>
        </div>
    </div>
</template>

<script>
    import AssetTypeTable from "./AssetTypeTable";
    export default {
        components:{
            AssetTypeTable
        },
        data() {
            return {
                form: new Form({
                    assettype: '',
                    description: '',
                    cwip:'yes',
                    tangible:'yes',
                    stores:'yes',
                    others:''
                }),
                name: "Define Asset Type",
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
                   this.form.put('api/assettype/'+this.updateId)
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
                    this.form.post('api/assettype')
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
                axios.get('api/assettype/'+id)
                    .then(response=>this.form.fill(response.data))
                    .catch(error=>swal('Failed!','Record Cant be fetched..','error'));
            }
        }

    }
</script>

<style scoped>

</style>
