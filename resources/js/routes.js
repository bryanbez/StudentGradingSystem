import App from './components/App';
import MainPage from './components/MainPage';
import ManageGrades from './components/Pages/ManageGrades'
import AddStudent from './components/Layouts/ManageStudentGrades/AddStudent'
import AllCritea from './components/Layouts/ManageStudentGrades/AllCritea.vue'
import Exam from './components/Layouts/ManageStudentGrades/Exam.vue'
import Assigment from './components/Layouts/ManageStudentGrades/Assignments.vue'
import Projects from './components/Layouts/ManageStudentGrades/Projects.vue'
import Quiz from './components/Layouts/ManageStudentGrades/Quiz.vue'
import Recitation from './components/Layouts/ManageStudentGrades/Recitation.vue'
import ViewStudent from './components/Layouts/ManageStudentInfo/ViewStudentInfo.vue'
import PrintGrades from './components/Pages/PrintGrades.vue'
import ManageSubjects from './components/Layouts/ManageSubjects/ManageSubjects'
import Settings from './components/Pages/Settings'
import ManageStudentSubjectGrades from './components/Layouts/ManageSubjects/ManageStudentSubjectGrades'

export default [
    { path: '/', component: MainPage },
    { path: '/managegrades', name: 'managegrades', component: ManageGrades },
    { path: '/managesubjects', name: 'managesubjects', component: ManageSubjects },
    { path: '/addstudent', component: AddStudent },
    { path: '/printgrades', component: PrintGrades},
    { path: '/settings', component: Settings },
    { path: '/managestudentsubjectgrades/:student_lrn/:student_year', name: 'managestudentsubjectgrades', component: ManageStudentSubjectGrades },
    { path: '/viewgrades/:student_lrn', name: 'viewgrades', component: AllCritea },
    { path: '/viewgrades/:student_lrn/exam/', name: 'exam', component: Exam },
    { path: '/viewgrades/:student_lrn/assignment/', name: 'assignment', component: Assigment },
    { path: '/viewgrades/:student_lrn/project/', name: 'project', component: Projects },
    { path: '/viewgrades/:student_lrn/quiz/', name: 'quiz', component: Quiz },
    { path: '/viewgrades/:student_lrn/recitation/', name: 'recitation', component: Recitation },
    { path: '/viewstudent/:student_lrn', name: 'viewstudent', component: ViewStudent }
]