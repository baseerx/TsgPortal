<template>
    <div class="row mt-2">
        <div class="col-12 table-responsive">
            <table class="table table-hover">
                <tr class="text-center">
                    <th>Sr.</th>
                    <th>Leasing Company Name</th>
                    <th>Description</th>
                    <th></th>
                </tr>
                <tr  class="text-center" v-for="(leasingCompanyData,index) in leasingCompanyData.data">
                    <td>{{++index}}</td>
                    <td>{{leasingCompanyData.name}}</td>
                    <td>{{leasingCompanyData.description}}</td>
                    <td>
                        <div class="d-flex flex-row justify-content-center">
                            <a @click="editRecord(leasingCompanyData.lcid)">
                                <i class="fas fa-lg fa-pen text-info">
                                </i>
                            </a>
                            <a class="pl-3" @click="deleteRecord(leasingCompanyData.lcid)">
                                <i class="fas fa-lg fa-trash text-danger">

                                </i>
                            </a>
                        </div>
                    </td>
                </tr>
            </table>
            <pagination :data="leasingCompanyData" class="pagination justify-content-center" @pagination-change-page="getData"></pagination>
        </div>
    </div>
</template>

<script>
    export default {
        props:['randno'],
        data(){
            return {
                leasingCompanyData:{},
                name: "LeasingCompanyTable",
            }
        },
        mounted() {
            this.getData();
        },
        watch:{
          randno:function () {
              this.getData();
          }
        },
        methods:{
            getData(page)
            {
                if (page=='undefined')
                {
                    page=1;
                }
                axios.get('api/leasingcompany?page='+page)
                    .then(response=>this.leasingCompanyData=response.data)
                    .catch(error=>console.log(error));
            },
            editRecord(id)
            {
                   this.$emit('updaterecord',id);
            },
            deleteRecord(id)
            {
                swal("You want to delete this record?", {
                    buttons: {
                        cancel: "CANCEL",
                        OK: true,
                    },
                })
                    .then((value) => {
                        switch (value) {

                            case "OK":
                                axios.delete('api/leasingcompany/'+id)
                                    .then(response=>{
                                        Fire.$emit('updateTable');
                                        swal('Congratulations!','Record Deleted Successfully..','success');
                                    })
                                    .catch(error=>swal('Failed!','Record Deletion Failed..','error'));
                                break;
                            default:
                                swal("Got away safely!");
                        }
                    });

            }
        }

    }
</script>

<style scoped>

</style>
