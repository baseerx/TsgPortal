<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" v-once>{{cardName}}</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Users</h3>

                                        <div class="card-tools">

                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover">
                                            <tr class="text-center">
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>User Type</th>
                                                <th>Modify</th>
                                            </tr>
                                            <tr class="text-center" v-for="records in records.data">
                                                <!--                                                <td>{{records.id}}</td>-->
                                                <td>{{records.name | capitalize}}</td>
                                                <td>{{records.email}}</td>
                                                <td>{{records.user_type}}</td>
                                                <td>
                                                    <!--<a class="btn btn-info btn-sm text-white" @click="assignRights(records.id,records.name)" title="Assigned Rights">-->
                                                      <!--Assign Rights 1st time-->
                                                    <!--</a>-->
                                                    <a class="btn btn-success btn-sm text-white" @click="assignRights(records.id,records.name)" title="New Rights">
                                                       Assign Rights
                                                    </a>
                                                </td>
                                            </tr>
                                            <pagination :data="records" @pagination-change-page="loadUser" class="pagination justify-content-center"></pagination>

                                            <!--<span class="text-right float-right text-success" v-text="message"></span>-->

                                        </table>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">

                <!-- Modal -->
                <div aria-hidden="true" aria-labelledby="UserRightModalLabel" class="modal fade" id="UserRightModal"
                     role="dialog" tabindex="-1">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="UserRightLabel">Rights Assignment for User: <span
                                    class="text-info" v-text="userName"></span></h5>
                                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit="userSubmit">
                                <div class="modal-body">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">User Right Table</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <table class="table table-bordered" id="table">
                                                <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Main Menu</th>
                                                    <th>Sub Menu</th>
                                                    <th>Rights</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr :id="'row'+ i" :value="m.mmenuId+'-'+m.smenuId"
                                                    v-for="(m,i) in listmenus.data">
                                                    <td v-text="i+1"></td>
                                                    <td :id="'td1'+i" v-text="m.mmenuDesc"></td>
                                                    <td :id="'td2'+i" v-text="m.smenuDesc">

                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <input :id="'add'+i" :name="'add'+i" type="checkbox">

                                                                <label :for="'add'+i" class="form-check-label">Add</label>

                                                            </div>
                                                            <div class="col-3">
                                                                <input :id="'edit'+i" :name="'edit'+i" type="checkbox">
                                                                <label :for="'edit'+i"
                                                                       class="form-check-label">Edit</label>

                                                            </div>
                                                            <div class="col-3">

                                                                <input :id="'delete'+i" :name="'delete'+i"
                                                                       type="checkbox">
                                                                <label :for="'delete'+i"
                                                                       class="form-check-label">Delete</label>
                                                            </div>
                                                            <div class="col-3">
                                                                <input :id="'print'+i"  :name="'print'+i"
                                                                       type="checkbox">
                                                                <label :for="'print'+i"
                                                                       class="form-check-label">Print</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">

                <!-- Modal -->
                <div aria-hidden="true" aria-labelledby="UserRightUpdateModalLabel" class="modal fade" id="UserRightUpdateModal" role="dialog" tabindex="-1">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="UserRightUpdateLabel">Rights Assignment for User: <span
                                    class="text-info" v-text="userName"></span></h5>
                                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit="userSub" id="form1">
                                <div class="modal-body">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">User Right Table</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <table class="table table-bordered" id="table1">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Main Menu</th>
                                                    <th>Sub Menu</th>
                                                    <th>Rights</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr :id="'row2'+ i" :value="m.mmenuId+'-'+m.smenuId"
                                                    v-for="(m,i) in listmenus1.data">
                                                    <td v-text="i+1"></td>
                                                    <td :id="'td21'+i" v-if="previous(m,i)==true">-</td>
                                                    <td :id="'td21'+i" v-else v-text="m.mmenuDesc"></td>
                                                    <td :id="'td22'+i" v-text="m.smenuDesc"></td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <input :id="'add1'+i" :name="'add1'+i" type="checkbox">
                                                                <label :for="'add1'+i" class="form-check-label">Add</label>
                                                            </div>
                                                            <div class="col-3">
                                                                <input :id="'edit1'+i" :name="'edit1'+i" type="checkbox">
                                                                <label :for="'edit1'+i" class="form-check-label">Edit</label>
                                                            </div>
                                                            <div class="col-3">
                                                                <input :id="'delete1'+i" :name="'delete1'+i" type="checkbox">
                                                                <label :for="'delete1'+i" class="form-check-label">Delete</label>
                                                            </div>
                                                            <div class="col-3">
                                                                <input :id="'print1'+i"  :name="'print1'+i" type="checkbox">
                                                                <label :for="'print1'+i" class="form-check-label">Print</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
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

                cardName: "Create New User",
                records: {},
                listmenus: {},
                listmenus1: {},
                message: '',
                userId: '',
                userName: '',
                listmenus2:{}


            }
        },
        mounted() {

            this.loadUser();
        },
        methods:
            {

                loadUser(page) {
                    if (page === 'undefined') {
                        page = 1;
                    }
                    axios.get('api/user?page=' + page)
                        .then(response => {
                            this.records = response.data;

                        })
                        .catch(error => console.log(error));
                },
                assignRights(id, name) {
                    this.userId = id;
                    this.userName = name;
                    document.getElementById("form1").reset();
                    axios.get('api/uservals/'+id)
                        .then(response=>{
                           if (response.data.length===0)
                           {
                               $("#UserRightModal").modal('show');

                               axios.get('api/urights')
                                   .then(response => {
                                       this.listmenus = response;

                                   })
                                   .catch(error => console.log(error));
                           }
                           else
                           {
                               $("#UserRightUpdateModal").modal('show');
                               axios.get('api/urights')
                                   .then(response => {

                                       this.listmenus1 = response;

                                       // console.log(this.listmenus1.data[0]);
                                   })
                                   .catch(error => console.log(error));

                                axios.get('api/urights/'+this.userId)
                                    .then(response=>{

                                        $.each(this.listmenus1.data, function(index1,value1){

                                           $.each(response.data,function (index,value) {

                                               let i = index + 1;
                                                if (value.mmenuId==value1.mmenuId && value.smenuId==value1.smenuId)
                                                {
                                                    let editVal = $("#edit1" + index1).is(':checked');
                                                    let deleteVal = $("#delete1" + index1).is(':checked');
                                                    let addVal = $("#add1" + index1).is(':checked');
                                                    let printVal = $("#print1" + index1).is(':checked');

                                                    if (value.cAdd==='true')
                                                    {
                                                        $("#add1"+index1).trigger('click');
                                                    }
                                                    if (value.cEdit=='true')
                                                    $("#edit1"+index1).trigger('click');
                                                    if (value.cDelete=='true')
                                                    $("#delete1"+index1).trigger('click');
                                                    if (value.cprint=='true')
                                                    $("#print1"+index1).trigger('click');
                                                }
                                           });
                                        });

                                    })
                                    .catch(error=>console.log(error));
                           }
                        }).catch(error=>console.log(error));

                },
                userSubmit() {
                    var tableRows = $('#table tr').length - 1;

                    var str = '';
                    for (let i = 0; i < tableRows; i++) {

                        var rowVal = $("#row" + i).attr('value');

                        let editVal = $("#edit" + i).is(':checked');
                        // alert($("#edit"+i).is(':checked'));
                        let printVal = $("#print" + i).is(':checked');
                        let deleteVal = $("#delete" + i).is(':checked');
                        let addVal = $("#add" + i).is(':checked');
                        let mmenu=$("#td1"+i).html();


                        let smenu=$("#td2"+i).html();

                        str += rowVal + '|' + editVal + '|' + printVal + '|' + deleteVal + '|' + addVal +'|'+mmenu+'|'+smenu+'&';

                    }
                    axios.put('api/urights/' + this.userId, {data: str})
                        .then(response =>
                        {
                            this.message="Data Updated Successfully.."
                        })
                        .catch(error => console.log(error));
                },
                userSub() {
                    var tableRows = $('#table1 tr').length - 1;
                    var str = '';
                    for (let i = 0; i < tableRows; i++) {

                        var rowVal = $("#row2" + i).attr('value');

                        let editVal = $("#edit1" + i).is(':checked');
                        // alert($("#edit"+i).is(':checked'));
                        let printVal = $("#print1" + i).is(':checked');
                        let deleteVal = $("#delete1" + i).is(':checked');
                        let addVal = $("#add1" + i).is(':checked');
                        let mmenu=$("#td21"+i).html();
                        let smenu=$("#td22"+i).html();

                        str += rowVal + '|' + editVal + '|' + printVal + '|' + deleteVal + '|' + addVal +'|'+mmenu+'|'+smenu+'&';

                    }

                    axios.put('api/uservals/' + this.userId, {data: str})
                        .then(response =>
                        {
                            this.message="Data Updated Successfully.."
                        })
                        .catch(error => console.log(error));

                },
                previous(a,b)
                {
                        let i=b-1;
                         if (b===0)
                         {
                             return false;
                         }
                        else if (this.listmenus1.data[i].mmenuDesc===a.mmenuDesc)
                        {
                            return true;
                        }
                        else
                        {
                            return false;
                        }
                }

            },
        filters: {
            capitalize: function (value) {
                if (!value) return ''
                value = value.toString()
                return value.charAt(0).toUpperCase() + value.slice(1);
            }
        }

    }
</script>
