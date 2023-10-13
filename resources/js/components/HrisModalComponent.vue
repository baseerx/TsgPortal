<template>
    <div>
        <div aria-hidden="true" aria-labelledby="employee_modalTitle" class="modal fade" id="hr_employee_modal" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info py-1 my-0">
                        <h5 class="modal-title" id="employee_modalTitle">Employees List</h5>
                    </div>
                    <div class="modal-header bg-default p-1">
                        <div class="container">
                            <tr>
                                <th><input class="form-control form-control-sm" placeholder="HRIS ID" type="text" v-model="hris_search"></th>
                                <th><input class="form-control form-control-sm" placeholder="Name" type="text" v-model="hris_name"></th>
                                <th><input class="form-control form-control-sm" placeholder="Designation" type="text" v-model="hris_designation"></th>
                                <th><input class="form-control form-control-sm" placeholder="BPS" type="text" v-model="hris_bps"></th>
                                <th><input class="form-control form-control-sm" placeholder="Department" type="text" v-model="hris_department"></th>
                                <th></th>
                            </tr>
                        </div>
                    </div>

                    <div class="modal-body py-0">

                        <div class="card-body table-responsive mt-0 py-0" style="height: 300px;">

                            <table class="table table-hover" v-if="hris_data.length" id="table_hris">
                                <thead class="bg-none">
                                <tr>
                                    <th>HRIS</th>
                                    <th>NAME</th>
                                    <th>DESIGNATION</th>
                                    <th>BPS</th>
                                    <th>DEPARTMENT</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="hr in HrisData" class="py-0 my-0" @dblclick="EditHris(hr.MyId)">
                                    <td>{{hr.MyId}}</td>
                                    <td>{{hr.Name}}</td>
                                    <td>{{hr.Designation}}</td>
                                    <td>{{hr.Grade}}</td>
                                    <td>{{hr.DeptName}}</td>
                                    <td><a @click="EditHris(hr.MyId)">
                                        <i class="fas fa-lg fa-check-circle text-success">

                                        </i>
                                    </a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data()
        {
            return{
                name: "HrisModalComponent",
                hris_data:[],
                hris_check: '',
                hris_search: '',
                hris_name: '',
                hris_designation: '',
                hris_bps: '',
                hris_department: ''
            }
        },
        mounted() {
            this.getHrisUsers();
        },
        watch:{

        },
        computed:{
            HrisData: function () {
                if (this.hris_bps) {
                    return this.hris_data.filter((hr) => {
                        return hr.Grade.toString().startsWith(this.hris_bps);
                    });
                } else if (this.hris_designation) {
                    return this.hris_data.filter((hr) => {
                        return hr.Designation.toString().toUpperCase().includes(this.hris_designation.toUpperCase());
                    });
                } else if (this.hris_search) {
                    return this.hris_data.filter((hr) => {
                        return hr.MyId.toString().startsWith(this.hris_search);
                    });
                } else if (this.hris_name) {
                    return this.hris_data.filter((hr) => {
                        return hr.Name.toString().includes(this.hris_name.toUpperCase());
                    });
                } else if (this.hris_department) {
                    return this.hris_data.filter((hr) => {
                        return hr.DeptName.toString().toUpperCase().includes(this.hris_department.toUpperCase());
                    });
                } else {
                    return this.hris_data;
                }
            }
        },
        methods:{
             getHrisUsers(){
                $('#hr_employee_modal').modal('show');
                 axios.get('api/hrisdata')
                    .then(response => this.hris_data = response.data)
                    .catch(error => console.log(error));
            },
            editRecord(id) {
                axios.get('api/user/' + id)
                    .then(response => {
                        this.currentId = id;
                        console.log(this.currentId);
                    })
                    .catch(error => console.log(error));
            },
            EditHris(val) {
                axios.get('api/emp_record/' + val)
                    .then(response => {
                        $('#hr_employee_modal').modal('hide');
                        this.$emit('allocatedto_field',response.data[0]);
                    })
                    .catch(error => console.log(error));
            }
        }
    }
</script>

<style scoped>
    .table>tbody>tr>td
    {
        padding-bottom: 0;
        padding-top: 0;
    }

    .table>thead>tr>td
    {
        padding-bottom: 0;
        padding-top: 0;
    }
    #table_hris{
        font-size: x-small;
    }

</style>
