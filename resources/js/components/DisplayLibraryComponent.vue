<template>
<div class="container">
    <span class="text-sm text-danger animated pulse infinite">Click the row and it will show download button below..</span>
    <LibraryTableComponent :category="catId" @onClickDownload="downloadFile"></LibraryTableComponent>
    <div :class="secClass" id="download"><a :href="fileName" target="_blank" @click="linkClick"><i class="fas fa-download fa-3x"></i></a>
    </div>
</div>
</template>

<script>
    import LibraryTableComponent from "./LibraryTableComponent";

    export default {
        components: {
            LibraryTableComponent

        },
        data() {
            return {
                subCatData: [],
                baseUrl: 'https://tsgportal.ntdc.com.pk/',
                catId: '',
                fileName: '',
                secClass:'d-none mt-3'
            }
        },
        mounted() {
            this.passedParm(this.$route.params.catid);
        },
        watch: {
            $route(to, from) {
                this.passedParm(to.params.catid);
            }
        },
        methods: {
            passedParm(parmId) {
                this.catId = parmId;
                axios.get(this.baseUrl + 'api/displaylib/' + parmId)
                    .then(response => this.subCatData = response.data)
                    .catch(error => console.log(error));
            },
            downloadFile: function (value) {
                let path = 'https://tsgportal.ntdc.com.pk/libtrans/' + value.toString();
                this.fileName = path;
                this.secClass='d-block mt-3 d-flex justify-content-center animated pulse delay-2s';
            },
            linkClick()
            {
                this.secClass='d-none';
            }

        }

    }
</script>

<style scoped>

</style>
