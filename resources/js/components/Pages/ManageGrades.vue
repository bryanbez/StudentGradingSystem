<template>
    <div class="container">
        <br />
        <h3>Manage Student Grades </h3>
        <br />
        
        <table class="table table-bordered">
            <tr>
                <th>Student Name</th>
                <th>Student Year</th>
                <th>Student Section</th>
                <th colspan="3"><center> Options </center></th>
            </tr>
            <tr v-for="singleStudent in studentList" :key="singleStudent.student_lrn">
                <td> {{ singleStudent.FullName }} </td>
                <td> {{ singleStudent.schoolYear | filterYear }} </td>
                <td> {{ singleStudent.section }}</td>
                <td><router-link v-bind:to="{name: 'viewstudent', params:{student_lrn: singleStudent.student_lrn}}" class="btn btn-primary"> View Information </router-link></td>
                <td><router-link v-bind:to="{name: 'viewgrades', params:{student_lrn: singleStudent.student_lrn}}" class="btn btn-secondary"> View Grades </router-link></td>
            </tr>

        </table>

        
    </div>
</template>

<script>
import AllCritea from '../Layouts/ManageStudentGrades/AllCritea';

export default {
    components: {
        AllCritea,
    },
    data: function() {
        return {
            studentList: [],
        }
    },
    created() {
        axios.get('http://localhost:8000/api/students')
            .then(response => {
                 this.studentList = response.data.data;
            });
           
    },
    methods: {
      
    },
    filters: {
        filterYear(value) {
            if(value == 1) {
                return '1st';
            }else if (value == 2) {
                return '2nd';
            }else if (value == 3) {
                return '3rd';
            }else if (value == 4) {
                return '4th';
            } else {
                //Wala
            }
        }
    }
}
</script>

<style scoped>

</style>