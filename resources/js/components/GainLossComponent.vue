<template>
    <v-app>
        <v-container fluid>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" v-text="this.name"></h4>
                </div>
                <div class="card-body">
                    <v-form @submit.prevent="submitRecord" id="check-login-form" ref="form">
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="salevalue">Sale Value</label>
                                <input type="number" required v-model="form.salevalue" id="salevalue" class="form-control"/>
                            </div>
                            <div class="form-group col-4">
                                <label for="bookvalue">Book Value</label>
                                <input type="number"
                                       required
                                       v-model="computeval" id="bookvalue"
                                       class="form-control"
                                >
                            </div>
                            <div class="form-group col-4">
                                <label for="gainloss">Gain/Loss</label>
                                <input type="number"
                                       required
                                       v-model="form.gainloss" id="gainloss"

                                       class="form-control"
                                >
                            </div>
                        </div>
                        <v-row
                            justify="center"
                            no-gutters
                        >
                            <v-col cols="12" md="6" offset-md="4">
                                <v-btn color="primary" form="check-login-form" large outlined type="submit"
                                       v-text="btnName"></v-btn>
                            </v-col>
                        </v-row>
                    </v-form>
                    <v-spacer></v-spacer>
                    <GainLossTable :randno="passrandNo" @updaterecord="updateRecord"></GainLossTable>
                </div>
            </div>
        </v-container>
    </v-app>

</template>

<script>
    import GainLossTable from "./GainLossTable";
    import DatePick from 'vue-date-pick';
    import 'vue-date-pick/dist/vueDatePick.css';

    export default {
        components: {
            GainLossTable,
            DatePick
        },
        data() {
            return {
                form: new Form({
                    salevalue: 0,
                    bookvalue: 0,
                    gainloss: 0
                }),
                name: "Gain/Loss on Disposal",
                computeval:0,
                numberRules: [
                    v => !!v || 'Text is required',
                ],
                btnName: 'Submit',
                updateId: 0,
                passrandNo: 0,
                assetsData: {}
            }
        },
        mounted() {
            Fire.$on('updateTable', () => {
                this.passrandNo = Math.random();
            });

        },
        watch: {

            computeval:function(val)
            {
                this.form.gainloss=this.form.salevalue-val;
                this.form.bookvalue=val;
            }

        },
        methods: {
            submitRecord(e) {
                e.preventDefault();
                // this.$refs.form.validate();
                if (this.updateId > 0) {
                    this.form.put('api/gainloss/' + this.updateId)
                        .then(reponse => {
                            swal("Congratulations!", "Record Updated Successfully..", "success");
                            Fire.$emit('updateTable');
                            this.btnName = 'Submit';
                            this.$refs.form.reset()
                        })
                        .catch(error => swal("Failed!", "Record Updation Failed..", "error"))
                } else {
                    this.form.post('api/gainloss')
                        .then(response => {
                            swal('Congratulations!', 'Data Has Been Successfully Submitted..', 'success');
                            Fire.$emit('updateTable');
                            this.form.reset();
                            this.form.bookvalue=0;
                        })
                        .catch(error => swal('Failed!', 'Data Has Been Successfully Submitted..', 'error'));
                }
            }
            ,
            updateRecord(id) {
                this.updateId = id;
                this.btnName = 'Update';
                axios.get('api/gainloss/' + id)
                    .then(response => this.form.fill(response.data))
                    .catch(error => swal('Failed!', 'Record Cant be fetched..', 'error'));
            }

        }

    }
</script>

<style scoped>

</style>
