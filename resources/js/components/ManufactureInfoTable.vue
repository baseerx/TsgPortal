<template>
    <div class="row mt-2">
        <div class="col-12 table-responsive">
            <table class="table table-hover">
                <tr class="text-center">
                    <th>Sr.</th>
                    <th>Manufacturer Name</th>
                    <th>Manufacturer Description</th>
                    <th></th>
                </tr>
                <tr  class="text-center" v-for="(manufInfoData,index) in manufInfoData.data">
                    <td>{{++index}}</td>
                    <td>{{manufInfoData.mname}}</td>
                    <td>{{manufInfoData.description}}</td>
                    <td>
                        <div class="d-flex flex-row justify-content-center">
                            <a @click="editRecord(manufInfoData.mfid)">
                                <i class="fas fa-lg fa-pen text-info">
                                </i>
                            </a>
                            <a class="pl-3" @click="deleteRecord(manufInfoData.mfid)">
                                <i class="fas fa-lg fa-trash text-danger">

                                </i>
                            </a>
                        </div>
                    </td>
                </tr>
            </table>
            <pagination :data="manufInfoData" class="pagination justify-content-center" @pagination-change-page="getData"></pagination>
        </div>
    </div>
</template>

<script>
    export default {
        props:['randno'],
        data(){
            return {
                manufInfoData:{},
                name: "AssetCatTable",
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
                axios.get('api/manufinfo?page='+page)
                    .then(response=>this.manufInfoData=response.data)
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
                                axios.delete('api/manufinfo/'+id)
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
