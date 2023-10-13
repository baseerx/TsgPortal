import Vue from 'vue'
import { Form, HasError, AlertError } from 'vform'
import VueRouter from 'vue-router'
import loading from 'vuejs-loading-screen'

Vue.use(loading)
Vue.use(VueRouter);

window.Form = Form;

window.Fire=new Vue();
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
var moment = require('moment');
moment().format();
const routes = [
    { path: '/profile', component: require('./components/ProfileComponent').default },
    { path: '/record_data', component: require('./components/RecordDataComponent').default },
    { path: '/record_search', component: require('./components/PreRecordsComponent').default },
    { path: '/login', component: require('./components/DashboardContentComponent').default },
    { path: '/users', component: require('./components/UsersComponent').default },
    { path: '/home', component: require('./components/HomeComponent').default },
    { path: '/instructor_panel', component: require('./components/InstructorPanelComponent').default },
    { path: '/trainees', component: require('./components/TraineesComponent').default },
    { path: '/examination', component: require('./components/ExaminationComponent').default },
    { path: '/admin', component: require('./components/AdminComponent').default },
    { path: '/update_user', component: require('./components/UpdateUserModal').default },
    { path: '/add_user', component: require('./components/AddUserComponent').default },
    { path: '/user_right', component: require('./components/UserRightComponent').default },
    { path: '/main_menu', component: require('./components/MainMenuComponent').default },
    { path: '/sub_menu', component: require('./components/SubMenuComponent').default },
    { path: '/course_type', component: require('./components/CourseTypeComponent').default },
    { path: '/course_cards', component: require('./components/CourseCardsComponent').default },
    { path: '/course_area', component: require('./components/CourseAreaComponent').default },
    { path: '/user_cards', component: require('./components/UserCardsComponent').default },
    { path: '/add_courses', component: require('./components/AddCourseComponent').default },
    { path: '/library', component: require('./components/LibraryComponent').default },
    { path: '/lib_cards', component: require('./components/LibCardComponent').default },
    { path: '/scategory', component: require('./components/SubCatComponent').default },
    { path: '/lib_transactions', component: require('./components/LibraryTransComponent').default },
    { path: '/menucards', component: require('./components/MenuCardsComponent').default },
    { path: '/category', component: require('./components/CategoryComponent').default },
    { path: '/instructor_card', component: require('./components/InstructorCardComponent').default },
    { path: '/add_instructor', component: require('./components/AddInstructorComponent').default },
    { path: '/ind_content', component: require('./components/individualContentComponent').default },
    { path: '/course_instructor', component: require('./components/CourseInstructorComponent').default },
    { path: '/emp_data', component: require('./components/EmployeeComponent').default },
    { path: '/coursesch', component: require('./components/CourseSchComponent').default },
    { path: '/definelib', component: require('./components/DefineLibraryComponent').default },
    { path: '/exam', component: require('./components/DefineExamComponent').default },
    { path: '/exam_card', component: require('./components/ExamCardComponent').default },
    { path: '/paper', component: require('./components/PaperComponent').default },
    { path: '/start_exam', component: require('./components/ResultComponent').default },
    { path: '/assig_upload', component: require('./components/AssignmentUploadComponent').default },
    { path: '/tpresentations', component: require('./components/PresentationComponent').default },
    { path: '/result', component: require('./components/BeforeResultComponent').default },
    { path: '/ind_scheduling', component: require('./components/IndividualScheduleComponent').default },
    { path: '/add_lecture', component: require('./components/AddLectureComponent').default },
    { path: '/test', component: require('./components/TestComponent').default },
    { path: '/feedback', component: require('./components/FeedBackComponent').default },
    { path: '/fdtext', component: require('./components/FeedBackDetailComponent').default },
    { path: '/lec_report', component: require('./components/LecFeedBackRep').default },
    { path: '/res_report', component: require('./components/ResultReportComponent').default },
    { path: '/answer_sheet', component: require('./components/AnswerSheetComponent').default },
    { path: '/certificates', component: require('./components/CertificateComponent').default },
    { path: '/positions', component: require('./components/PostionHoldersComponent').default },
    { path: '/lecture_feedback/:pid', component: require('./components/LectFeedBackComponent').default },
    { path: '/display_library/:catid', component: require('./components/DisplayLibraryComponent').default },
    { path: '/lecture/:trainemail', component: require('./components/LectureComponent').default },
    { path: '/pdisplay/:trainemail', component: require('./components/PresentationsDisplayComponent').default },
    { path: '/dashboard/:trainemail', component: require('./components/DashboardComponent').default },
    { path: '/add_letter/:param', component: require('./components/AddLetterComponent').default }
];

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
});

export default router
