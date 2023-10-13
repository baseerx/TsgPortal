<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{this.name}}</h4>
            </div>
            <div class="card-body">
                <form @submit.prevent="submitAssets">
                    <div class="form-group row setmargin">
                        <div class="col-2 text-right"><label>Asset Category</label></div>
                        <div class="col-4">
                            <div class="form-group">
                                <select :class="{ 'is-invalid': form.errors.has('assetcat') }" class="form-control" id="assetcategory" name="assetcategory" v-model="form.assetcat">
                                    <option value="land">Land</option>
                                    <option value="land buildings">Land Buildings</option>
                                    <option value="Electric And Gas Installations">Electric And Gas Installations</option>
                                    <option value="Furniture And Fixtures">Furniture And Fixtures</option>
                                    <option value="Laboratory Equipment">Laboratory Equipment</option>
                                    <option value="Office Equipment's">Office Equipment's</option>
                                    <option value="Office Equipment's">Office Equipment's</option>
                                    <option value="Computers And Ancillaries">Computers And Ancillaries</option>
                                    <option value="Machinery And Equipment's">Machinery And Equipment's</option>
                                    <option value="Library Books">Library Books</option>
                                    <option value="Vehicles">Vehicles</option>
                                </select>
                                <has-error :form="form" field="assetcat"></has-error>
                            </div>
                        </div>
                        <div class="col-2 text-right"><label>Description</label></div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('description') }" class="form-control" id="description" name="description"
                                   type="text" v-model="form.description">
                            <has-error :form="form" field="description"></has-error>
                        </div>
                    </div>
                    <div class="form-group row my-0">
                        <div class="col-2 text-right"><label>Accounts</label></div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('accounts') }" class="form-control" id="accounts" name="accounts"
                                   type="text" v-model="form.accounts">
                            <has-error :form="form" field="accounts"></has-error>
                        </div>
                        <div class="col-2 text-right"><label>Code Asset</label></div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('codeasset') }" class="form-control" id="codeasset" name="codeasset"
                                   type="text" v-model="form.codeasset">
                            <has-error :form="form" field="codeasset"></has-error>
                        </div>
                    </div>
                    <div class="form-group row setmargin">
                        <div class="col-2 text-right"><label>Code Depreciation</label></div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('codedepreciation') }" class="form-control" id="codedepreciation" name="codedepreciation"
                                   type="text" v-model="form.codedepreciation">
                            <has-error :form="form" field="codedepreciation"></has-error>
                        </div>
                        <div class="col-2 text-right"><label>Code Account Depreciation</label></div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('codeaccdepreciation') }" class="form-control" id="codeaccdepreciation" name="codeaccdepreciation"
                                   type="text" v-model="form.codeaccdepreciation">
                            <has-error :form="form" field="codeaccdepreciation"></has-error>
                        </div>
                    </div>
                    <div class="form-group row my-0">
                        <div class="col-2 text-right"><label>Code Gain Loss</label></div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('gainloss') }" class="form-control" id="gainloss" name="gainloss"
                                   type="text" v-model="form.gainloss">
                            <has-error :form="form" field="gainloss"></has-error>
                        </div>
                        <div class="col-2 text-right"><label>Code Impairement</label></div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('codeimpairement') }" class="form-control" id="codeimpairement" name="codeimpairement"
                                   type="text" v-model="form.codeimpairement">
                            <has-error :form="form" field="codeimpairement"></has-error>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-2 text-right"><label>Code revaluation</label></div>
                        <div class="col-4">
                            <input :class="{ 'is-invalid': form.errors.has('coderevaluation') }" class="form-control" id="coderevaluation" name="coderevaluation"
                                   type="text" v-model="form.coderevaluation">
                            <has-error :form="form" field="coderevaluation"></has-error>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-primary" id="submitBtn" name="submitBtn" type="submit"
                                v-text="btnName"></button>
                    </div>
<!--                    <alert-error :form="form" message="Fill all the fields correctly.."></alert-error>-->
                </form>
              <AssetCategoryTable @updaterecord="updateRecord" :randno="passrandNo"></AssetCategoryTable>
            </div>
        </div>
    </div>
</template>

<script>
    import AssetCategoryTable from "./AssetCategoryTable";
    export default {
        components:{
            AssetCategoryTable
        },
        data() {
            return {
                form: new Form({
                    assetcat: '',
                    description: '',
                    accounts:'',
                    codeasset:'',
                    codedepreciation:'',
                    codeaccdepreciation:'',
                    gainloss:'',
                    codeimpairement:'',
                    coderevaluation:''
                }),
                name: "Define Asset Category",
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
            submitAssets()
            {
                if (this.updateId>0)
                {
                   this.form.put('api/assetcategory/'+this.updateId)
                    .then(reponse=>{
                        Fire.$emit('updateTable');
                        this.btnName='Submit';
                        this.form.reset();
                    })
                    .catch(error=>swal("Failed!","Record Updation Failed..","error"))
                }
                else
                {
                    this.form.post('api/assetcategory')
                        .then(response=>{
                            Fire.$emit('updateTable');
                            this.form.reset();
                        })
                        .catch(error=>swal('Failed!','Data Submission failed Try different record..','error'));
                }
            },
            updateRecord(id)
            {
                this.updateId=id;
                this.btnName='Update';
                axios.get('api/assetcategory/'+id)
                    .then(response=>this.form.fill(response.data))
                    .catch(error=>swal('Failed!','Record Cant be fetched..','error'));
            },

        }

    }
</script>

<style scoped>
.setmargin{
    margin-bottom: -2%;
}
</style>
