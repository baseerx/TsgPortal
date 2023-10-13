<template>
    <v-app class="mt-2">
        <span class="badge badge-danger">Edit or Delete Record by clicking on row..</span>
        <v-card>
            <v-card-title>
                Gain Loss Table
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
                :items="depData"
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
                glid:0,
                headers: [
                    {
                        text: 'Sale Value',
                        align: 'start',
                        sortable: false,
                        value: 'salevalue',
                    },
                    { text: 'Book Value', value: 'bookvalue' },
                    { text: 'Gain Loss', value: 'gainloss' },
                ],
                depData:[],
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
                this.glid=e.glid;
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
                axios.get('api/gainloss')
                    .then(response=>this.depData=response.data)
                    .catch(error=>console.log(error));
            },
            editRecord()
            {
                this.$emit('updaterecord',this.glid);
            },
            deleteRecord()
            {
                axios.delete('api/gainloss/'+this.glid)
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
