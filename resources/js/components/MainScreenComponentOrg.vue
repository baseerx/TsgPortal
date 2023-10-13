<template>
    <div>
        <v-app>
            <v-container fluid>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{this.name}}</h4>
                    </div>
                    <div class="card-body">
                        <v-form @submit.prevent="submitRecord" id="check-login-form" ref="form">
                            <v-container>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="2"
                                    >
                                            <label for="name">Name</label>
                                            <select class="form-control" id="name" v-model="form.uid">
                                                <option :value="n.id" v-for="n in getuserName" v-text="n.name"></option>
                                            </select>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label>Record Date</label>
                                        <date-pick
                                            :format="'YYYY-MM-DD HH:mm'"
                                            :pickTime="true"
                                            class="form-control"
                                            v-model="form.datetime"
                                        ></date-pick>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="assetno">Asset no</label>
                                        <input class="form-control" id="assetno" name="assetno" type="text"
                                               v-model="form.assetno">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="lassetno">Legacy asset no</label>
                                        <input class="form-control" id="lassetno" name="lassetno" required
                                               type="text" v-model="form.lassetno">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2"
                                    >
                                        <label for="tangorintang">TangentOrInTang</label>
                                        <select class="form-control" id="tangorintang" name="tangorintang"
                                                v-model="form.tangorintang">
                                            <option value="select">Select</option>
                                            <option value="tangible">Tangible</option>
                                            <option value="intangible">InTangible</option>
                                        </select>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="companycode">Company Code</label>
                                        <input class="form-control" id="companycode" name="companycode"
                                               type="text" v-model="form.companycode">
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="assettype">Asset Type</label>
                                        <input class="form-control" id="assettype" name="assettype" required
                                               type="text" v-model="form.assettype">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="assetcls">Classification</label>
                                        <select class="form-control" id="assetcls" name="assetcls"
                                                required v-model="form.classification">
                                            <option value="">Select</option>
                                            <option :value="cd.aclid" v-for="cd in classificationData"
                                                    v-text="cd.assetcls"></option>
                                        </select>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="category">Category</label>
                                        <select class="form-control" id="category" name="category"
                                                required v-model="form.category">
                                            <option value="">Select</option>
                                            <option :value="c.acid" v-for="c in categoryData"
                                                    v-text="c.assetcat"></option>
                                        </select>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="units">Units</label>
                                        <input class="form-control" id="units" required type="text"
                                               v-model="form.units">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2"
                                    >
                                        <label for="inuse">In use</label>
                                        <select class="form-control" id="inuse" name="inuse"
                                                required v-model="form.inuse">
                                            <option value="">Select</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2"
                                    >
                                        <label for="physical_inventory">Physical inventory</label>
                                        <select class="form-control" id="physical_inventory" name="physical_inventory"
                                                required v-model="form.inphyicalinv">
                                            <option value="">Select</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>

                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="ddesc">Detail Desc</label>
                                        <input type="text" id="ddesc" class="form-control" v-model="form.detaildesc">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="assettagno">Asset tag no</label>
                                        <input type="text" id="assettagno" v-model="form.assettagno" class="form-control">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="own_leased">Owned|Leased</label>
                                        <input type="text" id="own_leased" class="form-control" v-model="form.ownedorleased">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="manuf">Manufacturer</label>
                                        <select name="manuf" id="manuf" v-model="form.manufacturer" class="form-control">
                                            <option value="">Select</option>
                                            <option v-for="m in manufData" :value="m.mfid" v-text="m.mname"></option>
                                        </select>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="massetno">Manf.asset no</label>
                                        <input type="text" id="massetno" class="form-control" v-model="form.assetsno">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="indicator">Indicator</label>
                                        <input type="text" id="indicator" class="form-control" v-model="form.indicator">
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="2"
                                    >
                                        <label for="c_of_origin">Country of origin</label>
                                        <input type="text" id="c_of_origin" name="c_of_origin" v-model="form.countryoforigin" class="form-control">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2"
                                    >
                                        <label for="wdetails">Warranty Details</label>
                                        <input type="text" class="form-control" v-model="form.warrentydetails" name="wdetails" id="wdetails">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2"
                                    >
                                        <label for="pno">PO No</label>
                                        <input type="text" id="pno" class="form-control" v-model="form.pono">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2"
                                    >
                                        <label for="location">Location</label>
                                        <input type="text" class="form-control" id="location" required v-model="form.location">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2"
                                    >
                                        <label for="custodian">Custodian</label>
                                        <input type="text" id="custodian" class="form-control" v-model="form.custodian">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2"
                                    >
                                        <label for="approved_budget">Approved budget</label>
                                        <input type="text" id="approved_budget" class="form-control" v-model="form.approvedbudget">
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="assetcost">Original Cost</label>
                                        <input type="text" required id="assetcost" class="form-control" v-model="form.assetcost">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="ccost">Current cost</label>
                                        <input type="text" class="form-control" id="ccost" name="ccost" required v-model="form.currentcost">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="svalue">Scrap value</label>
                                        <input type="text" class="form-control" id="svalue" name="svalue" required v-model="form.scrapvalue">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label>Capitalization Date</label>
                                        <date-pick
                                            :format="'YYYY-MM-DD HH:mm'"
                                            :pickTime="true"
                                            class="text-bold form-control"
                                            required
                                            v-model="form.captdate"
                                        ></date-pick>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label>Acquisition date</label>
                                        <date-pick
                                            :format="'YYYY-MM-DD HH:mm'"
                                            :pickTime="true"
                                            :rules="[v => !!v || 'Item is required']"
                                            class="text-bold form-control"
                                            required
                                            v-model="form.acqdate"
                                        ></date-pick>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="ulife">Useful Life</label>
                                        <input type="text" id="ulife" class="form-control" v-model="form.usefullife">
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="rlife">Remaining Life</label>
                                        <input type="text" id="rlife" required class="form-control" v-model="form.remaininglife">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="dmethod">Depreciation Methd</label>
                                        <input type="text" id="dmethod" required class="form-control"  v-model="form.depmethod">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="drate">Depreciation rate</label>
                                        <input type="text" id="drate" required class="form-control"  v-model="form.deprate">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="depreciation">Depreciation</label>
                                        <input type="text" id="depreciation" required class="form-control"  v-model="form.depreciation">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="adepreciation">Account Depreciation</label>
                                        <input type="text" id="adepreciation" required class="form-control"  v-model="form.accumdep">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="imp_charges">Impair Charges</label>
                                        <input type="text" id="imp_charges" required class="form-control"  v-model="form.impcharges">
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="aimp_charges">Acc-Impair Loses</label>
                                        <input type="text" id="aimp_charges" required class="form-control"  v-model="form.accumimplosses">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="charge_acc">charge acc</label>
                                        <input type="text" id="charge_acc" required class="form-control" v-model="form.depchargeacc">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="cost_center">Cost center</label>
                                        <input type="text" id="cost_center" required class="form-control" v-model="form.costcenter">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label>Revaluation Date</label>
                                        <date-pick
                                            :format="'YYYY-MM-DD HH:mm'"
                                            :pickTime="true"
                                            class="text-bold font-weight-bolder form-control"
                                            v-model="form.revdate"
                                        ></date-pick>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="rev_amount">Revalued Amount</label>
                                        <input type="text" id="rev_amount" required class="form-control"  v-model="form.revamount">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="dep_amount">DepRe Amount</label>
                                        <input type="text" id="dep_amount" class="form-control"  v-model="form.deprevamount">
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="acc_rev_amount">Acc-Revalued</label>
                                        <input type="text" id="acc_rev_amount" class="form-control"  v-model="form.accdeprevamount">
                                                                          </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label>Retirement Date</label>
                                        <date-pick
                                            :format="'YYYY-MM-DD HH:mm'"
                                            :pickTime="true"
                                            class="text-bold font-weight-bolder form-control"
                                            v-model="form.planretirdate"
                                        ></date-pick>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2"
                                    >
                                        <label for="lcomp">Leasing Comp</label>
                                        <select class="form-control" id="lcomp" v-model="form.lcompany">
                                            <option value="">Select</option>
                                            <option :value="l.lcid" v-for="l in lcompanyData" v-text="l.name"></option>
                                        </select>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="lagreement">lease agreement</label>
                                        <input type="text" id="lagreement" class="form-control"  v-model="form.lagreementno">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label>Ls-agreement date</label>
                                        <date-pick
                                            :format="'YYYY-MM-DD HH:mm'"
                                            :pickTime="true"
                                            class="text-bold font-weight-bolder form-control"
                                            v-model="form.lagreementdate"
                                        ></date-pick>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label>Lease s-date</label>
                                        <date-pick
                                            :format="'YYYY-MM-DD HH:mm'"
                                            :pickTime="true"
                                            class="text-bold font-weight-bolder form-control"
                                            v-model="form.lstartdate"
                                        ></date-pick>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="lease_length">Lease length</label>
                                        <input class="form-control" id="lease_length"
                                               type="text" v-model="form.leaselen">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="alloc_asset">Asset Alloc_to</label>
                                        <input class="form-control" id="alloc_asset" @focus="openHrisModal()"
                                               required
                                               type="text" v-model="form.allocatedto">
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="2">
                                        <label for="acode">Asset Code</label>
                                        <input class="form-control" id="acode"
                                               type="text" v-model="form.assetcode">
                                    </v-col>
                                </v-row>
                            </v-container>
                            <v-row
                                justify="center"
                                no-gutters
                            >
                                <v-col cols="12" md="2">
                                    <v-btn color="primary" form="check-login-form" large outlined type="submit"
                                           v-text="btnName"></v-btn>
                                </v-col>
                            </v-row>
                        </v-form>
                        <MainScreenTable :randno="passrandNo" @updaterecord="updateRecord"></MainScreenTable>
                        <template v-if="hrisModalFlag">
                            <HrisModalComponent @allocatedto_field="assignToAllocate"></HrisModalComponent>
                        </template>
                    </div>
                </div>
            </v-container>
        </v-app>
    </div>
</template>

<script>
    import DatePick from 'vue-date-pick';
    import 'vue-date-pick/dist/vueDatePick.css';
    import MainScreenTable from './MainScreenTable';
    import HrisModalComponent from "./HrisModalComponent";

    export default {
        components: {
            DatePick,
            MainScreenTable,
            HrisModalComponent
        },
        data() {
            return {
                form: new Form({
                    uid: 0,
                    datetime: '2019-01-01 14:30',
                    assetno: '',
                    lassetno: '',
                    tangorintang: 'select',
                    companycode: '',
                    assettype: '',
                    classification: '',
                    category: '',
                    units: '',
                    inphyicalinv: '',
                    detaildesc: '',
                    assettagno: '',
                    ownedorleased: '',
                    manufacturer: '',
                    assetsno: '',
                    countryoforigin: '',
                    warrentydetails: '',
                    pono: '',
                    location: '',
                    custodian: '',
                    approvedbudget: '',
                    assetcost: '',
                    currentcost: '',
                    scrapvalue: '',
                    captdate: '2019-01-01 14:30',
                    acqdate: '2019-01-01 14:30',
                    usefullife: '',
                    remaininglife: '',
                    depmethod: '',
                    deprate: '',
                    depreciation: '',
                    accumdep: '',
                    impcharges: '',
                    accumimplosses: '',
                    depchargeacc: '',
                    costcenter: '',
                    revdate: '2019-01-01 14:30',
                    revamount: '',
                    deprevamount: '',
                    accdeprevamount: '',
                    planretirdate: '2019-01-01 14:30',
                    lcompany: '',
                    lagreementno: '',
                    lagreementdate: '2019-01-01 14:30',
                    lstartdate: '2019-01-01 14:30',
                    leaselen: '',
                    allocatedto: '',
                    assetcode: ''
                }),
                name: "Entry Screen..",
                passrandNo: 0,
                hrisModalFlag: false,
                btnName: 'Submit',
                valid: true,
                textRules: [
                    v => !!v || 'it is required',
                    v => (v && v.length <= 50) || 'field must be less than 50 characters',
                ],
                numberRules: [
                    v => !!v || 'it is required',
                    v => /^[0-9]+$/.test(v) || 'field must be have numeric value',
                ],
                getuserName: [],
                manufData: [],
                classificationData: [],
                categoryData: [],
                lcompanyData: [],
                updateId: 0,

            }
        },
        mounted() {
            Fire.$on('updateTable', () => {
                this.passrandNo = Math.random();
            });
            this.getUserData();
            this.getManufData();
            this.getClassifficationData();
            this.getCategoryData();
            this.getLeasingCompData();
        },
        methods: {
            getUserData() {
                axios.get('api/user/loggedUser')
                    .then(response => {
                        this.getuserName = response.data
                        this.form.uid = this.getuserName[0].id;
                    })
                    .catch(error => console.log(error));
            },
            getClassifficationData() {
                axios.get('api/assetcls/forMainScreen')
                    .then(response => {
                        this.classificationData = response.data;
                    })
                    .catch(error => cosole.log(error));
            },
            getCategoryData() {
                axios.get('api/assetcategory/forMainScreen')
                    .then(response => {
                        this.categoryData = response.data;
                    })
                    .catch(error => cosole.log(error));
            },
            getLeasingCompData() {
                axios.get('api/leasingcompany/forMainScreen')
                    .then(response => {
                        this.lcompanyData = response.data;
                    })
                    .catch(error => console.log(error));
            },
            submitRecord() {
                this.$refs.form.validate();
                if (this.updateId > 0) {
                    this.form.put('api/mainscreen/' + this.updateId)
                        .then(reponse => {
                            Fire.$emit('updateTable');
                            this.btnName = 'Submit';
                            this.$refs.form.reset();
                            swal('Congratulations!', 'Record updated successfully..', 'success');
                        })
                        .catch(error => swal("Failed!", "AssetCode is same or somefields are invalid..", "error"))
                } else {
                    this.form.post('api/mainscreen')
                        .then(response => {
                            this.$refs.form.reset();
                            swal('Congratulations!', 'Record Added Successfully..', 'success');
                        })
                        .catch(error => swal("Failed!", "AssetCode is same or somefields are invalid..", "error"));
                }
            },
            getManufData() {
                axios.get('api/manufinfo/all')
                    .then(response => this.manufData = response.data)
                    .catch(error => console.log(error))
            },
            updateRecord(id) {
                this.updateId = id;
                this.btnName = 'Update';
                axios.get('api/mainscreen/' + id)
                    .then(response => this.form.fill(response.data))
                    .catch(error => swal('Failed!', 'Record Cant be fetched..', 'error'));
            },
            openHrisModal() {
                this.hrisModalFlag = true;
            },
            assignToAllocate(val) {
                this.form.allocatedto = val.name;
            }
        }
    }
</script>

<style scoped>
    .fontSizeClass {
        font-size: 0.7rem;
    }
</style>
