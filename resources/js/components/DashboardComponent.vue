<template>
  <div class="container">
    <h3 class="text-danger" v-if="courseData.length > 0">
      <span class="badge badge-primary text-white">Previous Trainings Data</span>
    </h3>
    <table class="table table-striped table-dark" v-if="courseData.length > 0">
      <thead>
        <tr>
          <th>#</th>
          <th>Training</th>
          <th>Training Title</th>
          <th>Start Date</th>
          <th>End Date</th>
        </tr>
      </thead>
      <tbody>
        <tr :key="index" v-for="(c, index) in courseData">
          <td>{{ ++index }}</td>
          <td>{{ c.cdesc }}</td>
          <td>{{ c.ctitle }}</td>
          <th class="text-primary" scope="row">
            {{ c.sdate.split("-").reverse().join("-") }}
          </th>
          <td>{{ c.edate.split("-").reverse().join("-") }}</td>
        </tr>
      </tbody>
    </table>
    <div class="d-none" id="trainees_data">
      <h3 class="text-danger">
        <span class="badge badge-danger text-white">Currently Enrolled Training</span>
      </h3>
      <table class="table table-dark">
        <thead>
          <tr>
            <th>Training</th>
            <th>Training Title</th>
            <th>Letter</th>
            <th>Trainee</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ this.traineesData.cdesc }}</td>
            <td>{{ this.traineesData.ctitle }}</td>
            <td>{{ this.traineesData.ltitle }}</td>
            <td>{{ this.traineesData.name }}</td>
            <td>
              <button
                :class="examClass"
                title="For Paper Start Click Here.."
                @click="startExam()"
              >
                Start Paper
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div id="sch_exam">
      <h3 class="text-danger">
        <span class="badge badge-danger text-white">Scheduled Exams</span>
      </h3>
      <table class="table table-dark">
        <thead>
          <tr>
            <th>Course</th>
            <th>Exam Title</th>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="e in examData">
            <td>{{ e.cdesc }}</td>
            <td>{{ e.examtitle }}</td>
            <td>{{ e.date }}</td>
            <td>{{ e.stime }}</td>
            <td>{{ e.etime }}</td>
            <td></td>
            <td>
              <button
                class="btn btn-sm btn-info text-white"
                v-if="e.exam_status == 1"
                title="For Paper Start Click Here.."
                @click="startExam(e.exam_id)"
              >
                Start Paper
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="d-none" id="ins_data">
      <h3 class="text-danger">
        <span class="badge badge-danger text-white">Individual Schedule</span>
      </h3>
      <table class="table table-dark">
        <thead>
          <tr>
            <th>#</th>
            <th>Training</th>
            <th>Trainee</th>
            <th>File Download</th>
          </tr>
        </thead>
        <tbody>
          <tr :key="index" v-for="(sch, index) in schData">
            <td>{{ ++index }}</td>
            <td>{{ sch.coursetype_desc }}</td>
            <td>{{ sch.name }}</td>
            <th>
              <a :href="'../indschedual/' + sch.file" target="_blank" :title="sch.file"
                ><i class="fas fa-2x fa-file-download"></i
              ></a>
            </th>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="card table-responsive" v-if="tableLength">
      <div class="card-header h3 text-danger">General Documents</div>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Description</th>
            <th scope="col">Training Type</th>
            <th scope="col">File Type</th>
            <th scope="col">Download</th>
          </tr>
        </thead>
        <tbody>
          <tr :key="index" v-for="(data, index) in files">
            <th scope="row">{{ ++index }}</th>
            <td>{{ data.description }}</td>
            <td>{{ data.trainingtype }}</td>
            <td>{{ data.filetype }}</td>
            <td>
              <a :href="'../indschedual/' + data.file" target="_blank" :title="data.file"
                ><i class="fas fa-2x fa-file-download"></i
              ></a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="card table-responsive" v-if="aDataLength">
      <div class="card-header h3 text-danger">General Documents</div>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Description</th>
            <th scope="col">File Type</th>
            <th scope="col">Training Type</th>
            <th scope="col">Download</th>
          </tr>
        </thead>
        <tbody>
          <tr :key="index" v-for="(data, index) in aData">
            <th scope="row">{{ ++index }}</th>
            <td>{{ data.description }}</td>
            <td>{{ data.filetype }}</td>
            <td>{{ data.coursetype_desc }}</td>
            <td>
              <a
                :href="'../presentation_files/' + data.file"
                target="_blank"
                :title="data.file"
                ><i class="fas fa-2x fa-file-download"></i
              ></a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import moment from "moment";
export default {
  data() {
    return {
      name: "NTDC TSG Training Portal",
      schData: [],
      traineesData: {},
      lectureData: {},
      courseData: [],
      presData: {},
      files: {},
      tableLength: 0,
      aData: {},
      examData: {},
      aDataLength: 0,
      lecDataLength: 0,
      presDataLen: 0,
      courseDataLen: 0,
      examClass: "btn btn-sm btn-info text-white d-none",
      baseUrl: "https://tsgportal.ntdc.com.pk/",
      traineeEmail: "",
      examStartTime: "",
      examCourseId: "",
      dataCheck: "",
      startButtonDate: moment(new Date()).format("YYYY-MM-DD"),
    };
  },
  mounted() {
    // this.userTableTrainee();
    this.getResults();
    this.getTraineeData();
    this.getAnnouncements();
    this.getSchedules();
    this.getExamData();
    this.checkDataFunc();
    // this.checkExam();
    Fire.$on("tdata", () => {
      $("#trainees_data").removeClass("d-none");
      $("#trainees_data").addClass("d-block");
    });
    Fire.$on("insdata", () => {
      $("#ins_data").removeClass("d-none");
      $("#ins_data").addClass("d-block");
    });
  },
  methods: {
    getAnnouncements() {
      axios
        .get(this.baseUrl + "api/display_data/onLogannouncement-")
        .then((response) => {
          this.aData = response.data;
          this.aDataLength = response.data.length;
        })
        .catch((error) => console.log("Annoucement data error."));
    },
    getExamData() {
      axios
        .get(this.baseUrl + "api/exam/tEmail-" + this.traineeEmail)
        .then((response) => {
          this.examData = response.data;
        })
        .catch((error) => console.log(error));
    },
    getSchedules() {
      axios
        .get(this.baseUrl + "api/display_data/instructor-" + this.traineeEmail)
        .then((response) => {
          if (response.data.length > 0) {
            this.schData = response.data;

            // console.log(this.schData.data.length);
            Fire.$emit("insdata");
          }
        })
        .catch((error) => console.log(error));

      // Fire.$emit('myEvent');
    },
    userTableTrainee() {
      axios
        .get("api/display_data/content")
        .then((response) => {
          this.files = response.data;
          this.tableLength = response.data.length;
        })
        .catch((error) =>
          console.log("error files/content occured in files retrieval..")
        );
    },
    startExam(exam) {
      axios
        .get(this.baseUrl + "api/exam/" + exam)
        .then((response) => {
          let stime = response.data.stime;
          let etime = response.data.etime;
          let now = moment();
          let currentTime = now.format("HH:mm:ss");
          this.checkDataFunc();
          let compVal = this.dataCheck.toString();
          // alert(compVal)
          if (currentTime >= stime && currentTime < etime && compVal === "true") {
            this.$router.push("/result");
          } else {
            swal(
              "Notice!",
              "You may have already submitted result or Kindly wait till the starting time..Starting Time: " +
                stime,
              "warning"
            );
          }
        })
        .catch((error) => console.log(error));
    },
    checkDataFunc() {
      axios
        .get(this.baseUrl + "api/display_data/dataCheck")
        .then((response) => {
          this.dataCheck = response.data;
        })
        .catch((error) => console.log(error));
    },
    getTraineeData() {
      axios
        .get(this.baseUrl + "api/display_data/onLogin")
        .then((response) => {
          if (response.data.length > 0) {
            this.traineesData = response.data[0];
            this.checkExam();
            Fire.$emit("tdata");
          }
        })
        .catch((error) => console.log(error));
    },
    getResults() {
      this.traineeEmail = this.$route.params.trainemail;
      axios
        .get(this.baseUrl + "api/display_data")
        .then((response) => {
          this.courseData = response.data;
        })
        .catch((error) => console.log(error));
    },
    checkExam() {
      axios
        .get(this.baseUrl + "api/exam/trainee_exam")
        .then((response) => {
          this.examStartTime = response.data.stime;
          this.examCourseId = response.data.course;
          let startD = response.data.date.split("-").reverse().join("-");
          let currentD = new Date();
          currentD = currentD.toISOString().split("T");
          currentD = currentD[0].split("-").reverse().join("-");
          if (currentD.toString() === startD.toString()) {
            this.examClass = "btn btn-sm btn-info text-white d-block";
          } else {
            this.examClass = "btn btn-sm btn-info text-white d-none";
          }
        })
        .catch((error) => console.log(error));
    },
  },
};
</script>

<style scoped>
.table-dark {
  color: #fff;
  background-color: #663300;
}

.table-dark th,
.table-dark td,
.table-dark thead th {
  border-color: #ff860d;
}
</style>
