<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card text-center">
                <div class="card-header">
                    <h3 class="text-info" v-once v-text="name"></h3>
                </div>
                <div class="card-body">
                    <form @submit="CreateSubMenu">
                        <div class="row">
                           <div class="col-2 offset-2"><label for="mMenu">Main Menu:</label></div>
                            <div class="col-8">
                                <select name="mMenu" id="mMenu" class="form-control w-50 form-group" v-model="mMenu">
                                    <option v-for="menu in mrecords" :value="menu.mmenuDesc" v-text="menu.mmenuDesc"></option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 offset-2"><label for="smenuName">Sub Menu:</label></div>
                            <div class="col-8">
                                <input name="smenuName" id="smenuName" autocomplete="off" class="form-control w-50 form-group" v-model="smenuName" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 offset-2"><label for="smenuUrl">Menu URL:</label></div>
                            <div class="col-8">
                                <input name="smenuUrl" id="smenuUrl" autocomplete="off" placeholder="URL Text" class="form-control w-50 form-group" v-model="smenuUrl" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 offset-2"><label for="smenuSort">Sort Num:</label></div>
                            <div class="col-8">
                                <input type="text" autocomplete="off" name="smenuSort" id="smenuSort" class="form-control w-50 form-group" v-model="smenuSort" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-7 offset-2">
                                <div class="input-group-append justify-content-center">
                                    <button class="btn btn-navbar text-primary" type="submit" data-toggle="tooltip" data-placement="bottom" title="Submit Data">
                                        <i class="fas fa-2x fa-plus-circle"></i>
                                    </button>
                                    <button :value="menu_id" @click="deleteMenu"
                                            class="btn btn-navbar text-delete text-danger" type="button" data-toggle="tooltip" data-placement="bottom" title="Delete Data">
                                        <i class="fas fa-2x fa-trash"></i>
                                    </button>
                                    <button @click="updateMenu" class="btn btn-navbar text-delete text-success"
                                            type="button" data-toggle="tooltip" data-placement="bottom" title="Update Data">
                                        <i class="fas fa-2x fa-pen"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">

                                <table class="table table-hover">
                                    <tr class="text-center thead-light">
                                        <th>Sr.</th>
                                        <th>Main Menu</th>
                                        <th>Sub Menu</th>
                                        <th>Sub Menu URL</th>
                                        <th>Sort Order</th>
                                        <th>Select</th>
                                    </tr>
                                    <tr :id="'row'+records.smenuId" class="text-center" v-for="(records,index) in records.data">
                                        <td>{{++index}}</td>
                                        <td>{{records.mmenuDesc}}</td>
                                        <td>{{records.smenuDesc}}</td>
                                        <td>{{records.smenuURL}}</td>
                                        <td>{{records.sOrder}}</td>
                                        <td>

                                            <a @click="selectRecord(records.smenuId)" class="pl-3" title="Select">
                                                <i class="fas fa-lg fa-pen text-info">

                                                </i>
                                            </a>
                                        </td>
                                    </tr>
                                    <pagination :data="records" class="pagination justify-content-center" @pagination-change-page="getResults"></pagination>
                                </table>
                        </div>
                    </form>


                </div>
                <div class="card-footer text-muted">
                    Tsg Portal @NTDC IT Directorate
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: "Add Sub Menu",
                records: {},
                mrecords: {},
                showRecords:{},
                menu_id: '',
                mMenu:'Select',
                smenuName:'',
                smenuUrl:'',
                smenuSort:'',
                rowId:''
            }
        },
        mounted() {
            Fire.$on('updateRecords',()=>{
                this.getResults();
            });
            this.getResults();
            this.mMenuRecords();
        },
        methods:
            {
                CreateSubMenu() {

                    axios.post('api/smenu', {sName: this.smenuName,sUrl:this.smenuUrl,Sort:this.smenuSort,Menu:this.mMenu})
                        .then(response => {
                            swal("Congratulations!","Sub Menu added successfully..","success");
                        })
                        .catch(error => {
                            swal("Notice!", "Menu name does not added..", "error");
                        });

                    this.form.reset();
                },
                selectRecord(id) {

                      axios.get('api/smenu/'+id)
                          .then(response=>{
                               this.showRecords=response.data;
                               this.mMenu=this.showRecords['mmenuDesc'];
                               this.smenuUrl=this.showRecords['smenuURL'];
                               this.smenuSort=this.showRecords['sOrder'];
                               this.smenuName=this.showRecords['smenuDesc'];
                               this.rowId=this.showRecords['smenuId'];
                          })

                },
                deleteMenu() {

                    axios.delete('api/smenu/' + this.rowId)
                        .then(response => {
                            swal("Notice!", "Record Deleted Successfully", "error")
                                .then((value) => {
                                    Fire.$emit('updateRecords');
                                });
                        })
                        .catch(error => {
                            swal("Notice!", "Some sort of error occured", "error");
                        });
                },
                updateMenu() {
                    axios.put('api/mmain/' + this.menu_id, {title: this.menu})
                        .then(response => {
                            swal("Congratulations!", "Your record updated successfully..", "success")
                                .then((value) => {
                                    Fire.$emit('updateRecords');
                                });


                        })
                        .catch(error => {
                            swal("Notice!", "Some sort of error occured", "error");
                        });
                },
                getResults(page)
                {
                    if(typeof page==='undefined')
                    {
                        page=1;
                    }
                    axios.get('api/smenu?page=' + page)
                        .then(response => this.records=response.data)
                        .catch(error => {
                            swal("Notice!", "Data is not loading..", "error");
                        })
                },
                mMenuRecords()
                {
                    axios.get('api/smenu/'+'All')
                        .then(response => this.mrecords=response.data)
                        .catch(error => {
                            swal("Notice!", "Data is not loading..", "error");
                        })
                },
                updateMenu()
                {
                    axios.put('api/smenu/'+this.rowId,{sName: this.smenuName,sUrl:this.smenuUrl,Sort:this.smenuSort,Menu:this.mMenu})
                        .then(response=>{
                            swal("Congratulation!", "Record Updated Successfully", "success")
                                .then(value => {
                                   location.reload();
                                });
                        })
                        .catch(error=>{
                            swal("Notice!", "Some sort of error occured", "error");
                        });
                }


            }
    }
</script>

<style scoped>

</style>
