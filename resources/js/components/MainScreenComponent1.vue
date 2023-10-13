<template>
    <div>
        <v-app>
            <v-container fluid>
                <v-card
                    class="mx-auto v-card v-card--shaped v-sheet theme--light elevation-18"
                >
                    <v-card-title class="bg-info" v-text="this.name">
                    </v-card-title>
                    <v-form @submit.prevent="submitRecord">
                        <v-container>
                            <v-row>
                                <v-col
                                    cols="12"
                                    md="2"
                                >
                                    <v-select
                                        :items="getuserName"
                                        :rules="[v => !!v || 'Item is required']"
                                        append-icon="mdi-plus"
                                        item-text="name"
                                        item-value="id"
                                        label="Name"
                                        required
                                        v-model="form.uid"
                                    ></v-select>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-datetime-picker
                                        :rules="[v => !!v || 'Item is required']"
                                        label="Select Datetime"
                                        required
                                        v-model="form.datetime"></v-datetime-picker>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        :counter="50"
                                        label="Asset no"
                                        v-model="form.assetno"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        :counter="50"
                                        :rules="numberRules"
                                        label="Lease asset no"
                                        required
                                        v-model="form.lassetno"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2"
                                >
                                    <v-select
                                        :items="typeData"
                                        :rules="[v => !!v || 'Item is required']"
                                        append-icon="mdi-plus"
                                        label="TangentOrInTang"
                                        required
                                        v-model="form.tangorintang"
                                    ></v-select>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        :counter="10"
                                        :rules="numberRules"
                                        label="Company code"
                                        required
                                        single-inline
                                        v-model="form.companycode"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        :counter="50"
                                        :rules="[v => !!v || 'Item is required',v => v.length <= 50 || 'field must be less than 50 characters']"
                                        label="Asset type"
                                        required
                                        v-model="form.assettype"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-select
                                        :items="classificationData"
                                        :rules="[v => !!v || 'Item is required']"
                                        append-icon="mdi-plus"
                                        item-text="assetcls"
                                        item-value="aclid"
                                        label="Classification"
                                        required
                                        v-model="form.classification"
                                    ></v-select>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-select
                                        :items="categoryData"
                                        :rules="[v => !!v || 'Item is required']"
                                        append-icon="mdi-plus"
                                        item-text="assetcat"
                                        item-value="acid"
                                        label="Category"
                                        required
                                        v-model="form.category"
                                    ></v-select>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        type="number"
                                        :counter="50"
                                        :rules="[v => !!v || 'Item is required',v => v.length <= 50 || 'field must be less than 50 characters']"
                                        label="Units"
                                        required
                                        v-model="form.units"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2"
                                >
                                    <v-select
                                        :items="inUseData"
                                        append-icon="mdi-plus"
                                        label="In use"
                                        v-model="form.inuse"
                                    ></v-select>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2"
                                >
                                    <v-select
                                        :items="inPhysicalData"
                                        append-icon="mdi-plus"
                                        label="Physical inventory"
                                        v-model="form.inphysicalinv"
                                    ></v-select>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        :counter="50"
                                        :rules="[v => !!v || 'Item is required',v => v.length <= 50 || 'field must be less than 50 characters']"
                                        label="Detail Desc"
                                        required
                                        v-model="form.detaildesc"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        :counter="50"
                                        label="Asset tag no"
                                        v-model="form.assettagno"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        :counter="50"
                                        label="Owned|Leased"
                                        v-model="form.ownedorleased"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        :counter="50"
                                        label="Manufacturer"
                                        v-model="form.manufacturer"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        :counter="11"
                                        label="Asset no"
                                        v-model="form.assetsno"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        :counter="50"
                                        label="Indicator"
                                        v-model="form.indicator"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col
                                    cols="12"
                                    md="2"
                                >
                                    <v-text-field
                                        :counter="50"
                                        label="Country of origin"
                                        v-model="form.countryoforigin"
                                    >

                                    </v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2"
                                >
                                    <v-text-field
                                        :counter="50"
                                        label="Warranty Details"
                                        v-model="form.warrentydetails"
                                    >

                                    </v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2"
                                >
                                    <v-text-field
                                        :counter="50"
                                        label="PO No"
                                        v-model="form.pono"
                                    >

                                    </v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2"
                                >
                                    <v-text-field
                                        :counter="50"
                                        :rules="[v => !!v || 'Item is required',v => v.length <= 50 || 'field must be less than 50 characters']"
                                        label="Location"
                                        required
                                        v-model="form.location"
                                    >

                                    </v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2"
                                >
                                    <v-text-field
                                        :counter="50"
                                        label="Custodian"
                                        v-model="form.custodian"
                                    >

                                    </v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2"
                                >
                                    <v-text-field
                                        type="number"
                                        :counter="50"
                                        label="Approved budget"
                                        v-model="form.approvedbudget"
                                    >

                                    </v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        type="number"
                                        :counter="11"
                                        :rules="[v => !!v || 'Item is required',v => v.length <= 11 || 'field must be less than 11 characters']"
                                        label="Current cost"
                                        required
                                        v-model="form.currentcost"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        type="number"
                                        :counter="11"
                                        :rules="[v => !!v || 'Item is required',v => v.length <= 11 || 'field must be less than 11 characters']"
                                        label="Scrap value"
                                        required
                                        v-model="form.scrapvalue"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-datetime-picker
                                        :rules="[v => !!v || 'Item is required']"
                                        label="Select Capitalization"
                                        required
                                        v-model="form.captdate"></v-datetime-picker>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-datetime-picker
                                        :rules="[v => !!v || 'Item is required']"
                                        label="Select Acquisition date"
                                        required
                                        v-model="form.acqdate"></v-datetime-picker>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        type="number"
                                        :counter="11"
                                        :rules="[v => !!v || 'Item is required',v => v.length <= 11 || 'field must be less than 11 characters']"
                                        label="Useful Life"
                                        required
                                        v-model="form.usefullife"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        type="number"
                                        :counter="11"
                                        :rules="[v => !!v || 'Item is required',v => v.length <= 11 || 'field must be less than 11 characters']"
                                        label="Remaining Life"
                                        required
                                        v-model="form.remaininglife"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        type="number"
                                        :counter="11"
                                        :rules="[v => !!v || 'Item is required',v => v.length <= 11 || 'field must be less than 11 characters']"
                                        label="Depreciation rate"
                                        required
                                        v-model="form.deprate"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        type="number"
                                        :counter="11"
                                        :rules="[v => !!v || 'Item is required',v => v.length <= 11 || 'field must be less than 11 characters']"
                                        label="Depreciation"
                                        required
                                        v-model="form.depreciation"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        type="number"
                                        :counter="11"
                                        :rules="[v => !!v || 'Item is required',v => v.length <= 11 || 'field must be less than 11 characters']"
                                        label="Accumulated Depreciation"
                                        required
                                        v-model="form.accumdep"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        type="number"
                                        :counter="11"
                                        :rules="[v => !!v || 'Item is required',v => v.length <= 11 || 'field must be less than 11 characters']"
                                        label="Impairement Charges"
                                        required
                                        v-model="form.impcharges"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        type="number"
                                        :counter="11"
                                        label="Accumulated Impairment Loses"
                                        v-model="form.accumimplosses"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        :counter="50"
                                        :rules="[v => !!v || 'Item is required',v => v.length <= 50 || 'field must be less than 50 characters']"
                                        label="Depreciation charge account"
                                        required
                                        v-model="form.depchargeacc"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        :counter="50"
                                        :rules="[v => !!v || 'Item is required',v => v.length <= 50 || 'field must be less than 50 characters']"
                                        label="Cost center"
                                        required
                                        v-model="form.costcenter"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-datetime-picker
                                        label="Select Revaluation Date"
                                        v-model="form.revdate"></v-datetime-picker>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        :counter="11"
                                        label="Revalued Amount"
                                        v-model="form.revamount"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        :counter="11"
                                        label="Dep-Revalued amount"
                                        v-model="form.deprevamount"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        :counter="11"
                                        label="Acc-Revalued amount"
                                        v-model="form.accdeprevamount"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-datetime-picker
                                        label="Select Planned Retirement Date"
                                        required
                                        v-model="form.planretirdate"></v-datetime-picker>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col
                                    cols="12"
                                    md="2"
                                >
                                    <v-select
                                        :items="lcompanyData"
                                        append-icon="mdi-plus"
                                        item-text="name"
                                        item-value="lcid"
                                        label="Leasing Cmpany"
                                        required
                                        v-model="form.lcompany"
                                    ></v-select>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        :counter="11"
                                        label="Lease agreement no"
                                        v-model="form.lagreementno"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-datetime-picker
                                        label="Select Lease agrmnt date"
                                        required
                                        v-model="form.lagreementdate"></v-datetime-picker>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-datetime-picker
                                        label="Select leasing start date"
                                        required
                                        v-model="form.lstartdate"></v-datetime-picker>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        :counter="11"
                                        label="Length of lease"
                                        v-model="form.leaselen"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="2">
                                    <v-text-field
                                        type="number"
                                        :counter="11"
                                        :rules="[v => !!v || 'Item is required',v => v.length <= 11 || 'field must be less than 11 characters']"
                                        label="Asset Cost"
                                        required
                                        v-model="form.assetcost"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                        <v-row
                            justify="center"
                            no-gutters
                        >
                            <v-col cols="12" md="2">
                                <v-btn type="submit" color="primary" large outlined v-text="btnName"></v-btn>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card>
            </v-container>
        </v-app>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    uid: 0,
                    datetime: new Date(),
                    assetno: '',
                    lassetno: '',
                    tangorintang: '',
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
                    captdate: new Date(),
                    acqdate: new Date(),
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
                    revdate: new Date(),
                    revamount: '',
                    deprevamount: '',
                    accdeprevamount: '',
                    planretirdate: new Date(),
                    lcompany: '',
                    lagreementno: '',
                    lagreementdate: new Date(),
                    lstartdate: new Date(),
                    leaselen: ''
                },
                name: "Entry Screen..",
                btnName:'Submit',
                numberRules: [
                    v => !!v || 'it is required',
                    v => v.length <= 50 || 'field must be less than 50 characters',
                ],
                getuserName: [],
                classificationData: [],
                categoryData: [],
                typeData: ['yes', 'no'],
                inUseData: ['yes', 'no'],
                inPhysicalData: ['yes', 'no'],
                lcompanyData: []
            }
        },
        mounted() {
            this.getUserData();
            this.getClassifficationData();
            this.getCategoryData();
            this.getLeasingCompData();
        },
        methods: {
            getUserData() {
                axios.get('api/user/loggedUser')
                    .then(response => {
                        this.getuserName = response.data;
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
                    .catch(error => cosole.log(error));
            },
            submitRecord()
            {
                this.form.post('api/mainscreen')
                .then(response=>console.log(response.data))
                .catch(error=>console.log(error));
            }
        }
    }
</script>

<style scoped>

</style>
