<template>
  <div
    class="modal fade"
    aria-hidden="true"
    aria-labelledby="exampleModalCenterTitle"
    data-backdrop="static"
    data-keyboard="false"
    id="before_result_modal"
    role="dialog"
    tabindex="-1"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-info" id="exampleModalCenterTitle">
            Instruction Before Examination
          </h5>
        </div>
        <div class="modal-body">
          <ul class="list-group">
            <li class="list-group-item active h4">
              Read All The Information/Warnings Carefully..
            </li>
            <li class="list-group-item">
              Attempt All The Mcqs Before Submiting Paper..<span
                class="badge badge-primary badge-pill float-right"
                >1</span
              >
            </li>
            <li class="list-group-item">
              keep an eye on the counter shown on the to right side of mcqs,if
              its stopped and optioned is showing selected then please reselect
              it..<span class="badge badge-primary badge-pill float-right"
                >2</span
              >
            </li>
            <li class="list-group-item text-capitalize">
              Log Out will reset your page but your already clicked mcqs data
              will remain on server side..<span
                class="badge badge-primary badge-pill float-right"
                >3</span
              >
            </li>
            <li class="list-group-item text-capitalize">
              Don't close the exam tab or browser once the exam is started<span
                class="badge badge-primary badge-pill float-right"
                >4</span
              >
            </li>
            <li class="list-group-item text-capitalize">
              Paper will be submitted automatically as time given time ends<span
                class="badge badge-primary badge-pill float-right"
                >5</span
              >
            </li>
            <li class="list-group-item text-capitalize">
              you are not allowed to use any other electronic device/Mobile
              Phone when exam starts..<span
                class="badge badge-primary badge-pill float-right"
                >6</span
              >
            </li>
            <li class="list-group-item">
              Exam timing is 1 hour which will not be extended in any
              case..<span class="badge badge-primary badge-pill float-right"
                >7</span
              >
            </li>
            <li class="list-group-item">
              Don't forget to submit in the end..<span
                class="badge badge-primary badge-pill float-right"
                >8</span
              >
            </li>
              <li class="list-group-item">
              Remaining Minutes for auto ending the exam is shown on the right bottom side<span class="badge badge-primary badge-pill float-right">9</span>
            </li>
          </ul>
        </div>
        <div class="modal-footer">
          <button
            class="btn btn-danger animated pulse bounceInLeft"
            @click="startExam"
            type="button"
          >
            Start Paper
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    this.triggerModal();
  },
  methods: {
    triggerModal() {
      $("#before_result_modal").modal("show");
    },
    startExam() {
      $("#before_result_modal").modal("hide");
      this.$router.push({ path: "/start_exam" });
    },
  },
};
</script>

<style scoped>
</style>
