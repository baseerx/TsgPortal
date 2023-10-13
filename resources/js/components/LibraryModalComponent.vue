<template>
    <v-row justify="center">
        <v-dialog
            v-model="dialog"
            max-width="290"
        >
            <v-card>
                <v-card-title class="headline">Do You Want To Download This File?</v-card-title>
                <v-card-text>
          If Yes Then Press Agree Otherwise Disagree!!
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="green darken-1"
                        text
                        @click="Disagree"
                    >
                        Disagree
                    </v-btn>

                    <v-btn
                        color="green darken-1"
                        text
                        @click="Agree"
                    >
                        <a :href="fileName" target="_blank">Agree</a>
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<script>
    export default {
        props:['showModal'],
        data () {
            return {
                dialog: false,
                fileName:""
            }
        },
        watch:{
            showModal:function () {
              this.dialog=true;
            }
        },
        methods:{
            Disagree:function () {
             this.dialog=false;
            },
            Agree:function () {
                let path = 'https://tsgportal.ntdc.com.pk/libtrans/' + this.showModal.toString();
                this.fileName = path;
               this.dialog=false;
            }
        }
    }
</script>
<style scoped>

</style>
