<template>
    <div class="container">
        <br />
        <h3>Manage Grades of {{ student_info.student_name }} </h3>
        <br />

        <table class="table">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="singleSubject in fetchedSubjectInfo" :key="singleSubject.subj_code">
                    <td scope="row"> {{ singleSubject.subj_name }} </td>
                    <td><router-link :to="{name: 'managestudentgrades', params:{student_lrn: student_info.student_lrn, student_year: student_info.student_yr_no_filter, subject_code: singleSubject.subj_code}}" class="btn btn-primary"> View Grades </router-link></td>
                </tr>
            </tbody>
        </table>

    </div>
</template>

<script>
export default {
    data() {
        return {
            fetchedSubjectInfo: [],
            student_info: {
                 student_lrn: '',
                 student_yr: '',
                 student_name: '',
                 student_yr_no_filter: ''
            },
            finalGrade: '',
           
        }
    },
    created() {
        this.student_info.student_lrn = this.$route.params.student_lrn;
        this.student_info.student_yr = this.yearFilter(this.$route.params.student_year);
        this.student_info.student_yr_no_filter = this.$route.params.student_year;
        this.fetchSubjectsInSpecificYearAndStudentName(this.student_info.student_yr, this.student_info.student_lrn)
    },
    methods: {
        fetchSubjectsInSpecificYearAndStudentName(studentYear, student_lrn) {
            axios.get('http://localhost:8000/api/showSubjectInYear/'+studentYear).then(
                response => {
                    this.fetchedSubjectInfo = response.data;
            });
            axios.get('http://localhost:8000/api/student/'+student_lrn)
                .then(response => {
                   this.student_info.student_name = response.data[0].studentLastName + ', ' + response.data[0].studentFirstName + ' ' + response.data[0].studentMiddleName;
            });
        },
        yearFilter(studentYear) {
            if (studentYear == 1) {
                return '1st'
            } else if(studentYear == 2) {
                return '2nd'
            } else if(studentYear == 3) {
                return '3rd'
            } else if(studentYear == 4) {
                return '4th'
            }
        },

       
    }
    
}
</script>

<style scoped>

</style>