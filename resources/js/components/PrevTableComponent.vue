<template>
    <v-app>
        <v-card>
            <v-card-title>
                <span class="text-info">Data Related To Previous Trainings</span>
                <v-spacer></v-spacer>
                <v-text-field
                    hide-details
                    label="Search"
                    single-line
                    v-model="search"
                ></v-text-field>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="libraryData"
                :search="search"
                @click:row="openDetail"
            >
            </v-data-table>
        </v-card>
    </v-app>
</template>
<script>
    export default {
        props: ['training'],
        data() {
            return {
                search: '',
                libraryData: [],
                headers: [
                    {
                        text: 'Description',
                        align: 'left',
                        sortable: false,
                        value: 'description',
                    },
                    {text: 'Type', value: 'filetype'},
                    {text: 'File', value: 'file'},
                ],
            }
        },
        watch: {
            training: function (newVal, oldVal) {
                 this.getData(newVal);
            }
        },
        mounted() {
        },
        methods: {
            getData(newVal) {
                axios.get('api/previousdata/'+newVal)
                    .then(response => this.libraryData = response.data)
                    .catch(error => console.log(error));
            },
            openDetail(e)
            {
                this.$emit('onClickDownload', e.file);
            }
        }
    }
</script>
