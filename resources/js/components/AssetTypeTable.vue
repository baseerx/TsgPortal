<template>
    <div class="row mt-2">
        <div class="col-12 table-responsive">
            <table class="table table-hover">
                <tr class="text-center">
                    <th>Sr.</th>
                    <th>Asset Type</th>
                    <th>Description</th>
                    <th>CWIP</th>
                    <th></th>
                </tr>
                <tr  class="text-center" v-for="(assetsData,index) in assetsData.data">
                    <td>{{++index}}</td>
                    <td>{{assetsData.assettype}}</td>
                    <td>{{assetsData.description}}</td>
                    <td>{{assetsData.cwip}}</td>
                    <td>
                        <div class="d-flex flex-row justify-content-center">
                            <a @click="editRecord(assetsData.asstype_id)">
                                <i class="fas fa-lg fa-pen text-info">
                                </i>
                            </a>
                            <a class="pl-3" @click="deleteRecord(assetsData.asstype_id)">
                                <i class="fas fa-lg fa-trash text-danger">

                                </i>
                            </a>
                        </div>
                    </td>
                </tr>
            </table>
            <pagination :data="assetsData" class="pagination justify-content-center" @pagination-change-page="getData"></pagination>
        </div>
    </div>
</template>

<script>
    export default {
        props:['randno'],
        data(){
            return {
                assetsData:{},
                name: "AssetTypeTable",
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
                axios.get('api/assettype?page='+page)
                    .then(response=>this.assetsData=response.data)
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
                                axios.delete('api/assettype/'+id)
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
