<template>
    <div>

        <div class="container">
            <div class="col-md-12 col-lg-12">
                <br />
                <div class="alert alert-info" v-if="message != ''">
                    <p> {{ message }}  <a style="float: right; cursor: pointer" @click="dismissMessage()">X</a></p>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
                </div>
               <br />
                <h3>Assignments of {{ studentFullName }} in the subject of {{ subj_name }}</h3>
                 <hr />
                   <h5 v-if="allAssignmentRecords != null"> Total Assignments: {{ assignmentResult.assignment_count }} </h5>
                  <hr />
                  <h5> Add/ Update Assignment Records</h5>
                  <form @submit.prevent="saveOrUpdateAssignmentRecord">
                    <table class="table table-bordered">
                        <tr>
                            <th> Date Given</th>
                            <th> Grade </th>
                            <th colspan="2"> Options</th>
                        </tr>
                        <tr >
                            <td> <input type="date" class="form-control" v-model="input.dateOfAssignment"> </td>
                            <td> <input type="text" class="form-control" v-model="input.grade"> </td>
                            <td> <button class="btn btn-primary" type="submit">Save</button> </td>  
                        </tr>
                    </table>
                    </form>
                     <td> <button class="btn btn-primary" @click="clearInputs()">Clear</button> </td>
                    <br />
                    <hr />
                    <div v-if="allAssignmentRecords != null">

                        <h5> Assignment Records</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th> Date Given</th>
                                <th> Grade </th>
                                <th colspan="2"> Options </th>
                            </tr>
                            <tr v-for="singleAssignmentRecord in allAssignmentRecords" :key="singleAssignmentRecord.assignment_id">
                                <td> {{ singleAssignmentRecord.date_of_assignment }} </td>
                                <td> {{ singleAssignmentRecord.grade }} </td>
                            <td> <button class="btn btn-primary" @click="editAssignmentRecord(singleAssignmentRecord.assignment_id)">Edit</button> </td>
                                <td> <button class="btn btn-danger" @click="removeAssignmentRecord(singleAssignmentRecord.assignment_id)">Remove</button> </td>
                            </tr>
                            <tr>
                                <td>Final Grade in Assignment</td>
                                <td> {{ assignmentResult.finalGrade }} ({{ assignmentResult.assignment_count }} of {{ assignmentResult.max_assignment_number}} assignment passed) </td>
                            </tr>
                        </table>

                    </div>
                    <p id="noResult" v-else> No Assignment Records </p>
                    <br />
                   
                    <hr />

                   <router-link :to="{name: 'managestudentgrades', params:{student_lrn: input.student_lrn, student_year: schoolYr, subject_code: input.subj_code}}" class="btn btn-danger"> Back </router-link>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            assignmentIdToUpdate: '',
            input: {
                student_lrn: '',
                subj_code: '',
                dateOfAssignment: '',
                grade: '',
            },
            allAssignmentRecords: [],
            studentFullName: '',
            assignmentResult: [],
            message: '',
            subj_name: '',
            schoolYr: '',
         
        }
    },
    created() {
            this.input.student_lrn = this.$route.params.student_lrn;
            this.input.subj_code = this.$route.params.subject_code;
            this.schoolYr = this.$route.params.student_year;
            console.log(this.input.student_lrn + '/ Assignment /' + this.input.subj_code);

            axios.get('http://localhost:8000/api/student/'+this.input.student_lrn)
                .then(response => {
                  this.studentFullName = response.data[0].studentLastName + ', ' + response.data[0].studentFirstName;
            });

            axios.get(`http://localhost:8000/api/subject/${this.input.subj_code}`).then(
                response => {
                    console.log(response)
                    this.subj_name = response.data[0].subj_name;
            });


          this.refreshList()
    },
    methods: {
       dismissMessage() {
           this.message = '';
       },
       saveOrUpdateAssignmentRecord() {
             if(this.assignmentIdToUpdate != '') {
                axios.put(`http://localhost:8000/api/assignments/${this.assignmentIdToUpdate}`, this.input).then(
                    response => {
                    console.log(response)
                    this.message = response.data;
                    this.refreshList()
                    this.clearInputs()
                });
            }
            else {
                axios.post('http://localhost:8000/api/assignments', this.input).then(
                    response => {
                    console.log(response)
                    this.message = response.data;
                    this.refreshList()
                    this.clearInputs()      
                });
            }
       },
       editAssignmentRecord(assignmentID) {
            axios.get(`http://localhost:8000/api/assignments/${assignmentID}/edit`).then(
                response => {
                    console.log(response)
                    this.assignmentIdToUpdate = response.data[0].assignment_id;
                    this.input.dateOfAssignment = response.data[0].date_of_assignment;
                    this.input.grade = response.data[0].grade;
                  
                }
            );

       },
       removeAssignmentRecord(assignmentID) {
            if(confirm('Are you sure to delete this record? ')){
                 axios.delete(`http://localhost:8000/api/assignments/${assignmentID}`).then(
                    response => {
                    this.message = response.data;
                    this.refreshList()
                    }
                );
            }
       },
       clearInputs() {
            this.assignmentIdToUpdate = '';
            this.input.dateOfAssignment = '';
            this.input.grade = '';
       },
       refreshList() {
            axios.get(`http://localhost:8000/api/fetchassignments/${this.input.student_lrn}/${this.input.subj_code}`).then(
                response => {
                    console.log(response.data)
                     if (response.data.assignments.length == 0) {
                        this.allAssignmentRecords = null;
                     }
                     else {
                        this.allAssignmentRecords = response.data.assignments;
                        this.assignmentResult = response.data.overallData[0]; 
                    }
            });
          
       }
     
      
    }

}
</script>

<style scoped>

</style>