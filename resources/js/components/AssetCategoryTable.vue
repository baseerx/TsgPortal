<template>
    <v-app class="mt-2">
        <span class="badge badge-danger">Edit or Delete Record by clicking on row..</span>
        <v-card>
            <v-card-title>
                Asset Category Table
                <v-spacer></v-spacer>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Search"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
            <v-data-table
                @click:row="showRecord"
                :headers="headers"
                :items="assetsCatData"
                :search="search"
            ></v-data-table>
        </v-card>
    </v-app>
</template>
<script>
    export default {
        props:['randno'],
        data () {
            return {
                search: '',
                recId:0,
                headers: [
                    {
                        text: 'Asset Category',
                        align: 'start',
                        sortable: false,
                        value: 'assetcat',
                    },
                    { text: 'Description', value: 'description' },
                    { text: 'Accounts', value: 'accounts' },
                ],
                assetsCatData:[],
            }
        },
        watch:{
            randno:function () {
                this.getData();
            }
        },
       mounted() {
           Fire.$on('updateTable',()=>{
               this.getData();
           });
            this.getData();
       },
        methods:{
            showRecord(e)
            {
                this.recId=e.acid;
                swal("Perform action on the clicked Record?", {
                    buttons: {
                        Edit: "Edit",
                        Delete: true,
                    },
                })
                    .then((value) => {
                        switch (value) {

                            case "Delete":
                            this.deleteRecord();
                                break;
                            default:
                               this.editRecord();
                        }
                    });

            },
            getData()
            {
                axios.get('api/assetcategory')
                    .then(response=>this.assetsCatData=response.data)
                    .catch(error=>console.log(error));
            },
            editRecord()
            {
                this.$emit('updaterecord',this.recId);
            },
            deleteRecord()
            {
                axios.delete('api/assetcategory/'+this.recId)
                    .then(response=>{
                        Fire.$emit('updateTable');
                        swal('Congratulations!','Record Deleted Successfully..','success');
                    })
                    .catch(error=>swal('Failed!','Record Deletion Failed..','error'));
            }
        }
    }
</script>

<style scoped>

</style>
