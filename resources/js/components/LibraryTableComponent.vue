<template>
    <v-app>
        <v-card>
            <v-card-title>
                Library E Books
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
        <LibraryModalComponent :showModal="flag"></LibraryModalComponent>
    </v-app>
</template>
<script>
    import LibraryModalComponent from "./LibraryModalComponent";
    export default {
        components:{
          LibraryModalComponent
        },
        props: ['category'],
        data() {
            return {
                search: '',
                libraryData: [],
                baseUrl: 'https://tsgportal.ntdc.com.pk/',
                headers: [
                    {
                        text: 'Title',
                        align: 'left',
                        sortable: false,
                        value: 'description',
                    },
                    {text: 'Code', value: 'book_code'},
                    {text: 'Author', value: 'author_name'},
                    {text: 'Publisher', value: 'publisher'},
                ],
                flag:0
            }
        },
        watch: {
            category: function (newVal, oldVal) {
                let libraryId = 'cat_' + newVal;
                this.getData(libraryId);
            }
        },
        methods: {
            getData(id) {
                axios.get(this.baseUrl + 'api/libtrans/' + id)
                    .then(response => this.libraryData = response.data)
                    .catch(error => console.log(error));
            },
            openDetail(e) {
               this.flag=e.file;
                // this.$emit('onClickDownload', e.file);
            }
        }
    }
</script>
