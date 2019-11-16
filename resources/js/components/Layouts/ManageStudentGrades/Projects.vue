<template>
    <div>

        <div class="container">
            <div class="col-md-12 col-lg-12">
                  <br />
                    <div class="alert alert-info" v-if="message != ''">
                        <p> {{ message }}  <a style="float: right; cursor: pointer" @click="dismissMessage()">X</a></p>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
                    </div>           
               <br />
                <h3>Projects of {{ studentFullName }}</h3>
                 <hr />
                   <h5> Total Projects: {{ projectData.project_count }} </h5>
                  <hr />
                  <h5> Add/ Update Project Records</h5>
                    <form @submit.prevent="saveOrUpdateProjectRecord">
                    <table class="table table-bordered">
                        <tr>
                            <th> Date Given</th>
                            <th> Grade </th>
                            <th colspan="2"> Options</th>
                        </tr>
                        <tr >
                            <td> <input type="date" class="form-control" v-model="input.dateOfProject"> </td>
                            <td> <input type="text" class="form-control" v-model="input.grade"> </td>
                            <td> <button class="btn btn-primary" type="submit">Save</button> </td>  
                        </tr>
                    </table>
                    </form>
                     <td> <button class="btn btn-primary" @click="clearInputs()">Clear</button> </td>
                       <br />
                    <hr />
                    <h5> Project Records</h5>
                 
                    <table class="table table-bordered">
                        <tr>
                            <th> Date Given</th>
                            <th> Grade </th>
                            <th colspan="2"> Options </th>
                        </tr>
                        <tr v-for="singleProjectRecord in projectRecords" :key="singleProjectRecord.project_id">
                            <td> {{ singleProjectRecord.date_of_project }}  </td>
                            <td> {{ singleProjectRecord.grade }}  </td>
                            <td> <button class="btn btn-primary" @click="editProjectRecord(singleProjectRecord.project_id)">Edit</button> </td>
                            <td> <button class="btn btn-danger" @click="removeProjectRecord(singleProjectRecord.project_id)">Remove</button></td>
                        </tr>
                        <tr>
                            <td> Final Grade: </td>
                            <td colspan="3">{{ projectData.equivalent }}</td>
                        </tr>
                    </table>
                    <br />

                    <router-link v-bind:to="{name: 'viewgrades', params:{student_lrn: this.input.student_lrn}}" class="btn btn-danger">Back</router-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            input: {
                student_lrn: '',
                dateOfProject: '',
                grade: '',
            },
            projectIdToUpdate: '',
            projectRecords: [],
            projectData: [],
            message: '',
            studentFullName: ''
        }
    },
    created() {
        this.input.student_lrn = this.$route.params.student_lrn;
       
        axios.get(`http://localhost:8000/api/fetchprojects/${this.input.student_lrn}`).then(
            response => {
                this.projectRecords = response.data.projectRecords;
                this.projectData = response.data.projectData[0];
                console.log(this.projectData)
            }
        );
        axios.get('http://localhost:8000/api/student/'+this.input.student_lrn)
             .then(response => {
                this.studentFullName = response.data[0].FullName;
        });

    },
    methods: {
        dismissMessage() {
           this.message = '';
       },
       saveOrUpdateProjectRecord() {
             if(this.projectIdToUpdate != '') {
                axios.put(`http://localhost:8000/api/projects/${this.projectIdToUpdate}`, this.input).then(
                    response => {
                    console.log(response)
                    this.message = response.data;
                    this.refreshList()
                    this.clearInputs()
                });
            }
            else {
                axios.post('http://localhost:8000/api/projects', this.input).then(
                    response => {
                    console.log(response)
                    this.message = response.data;
                    this.refreshList()
                    this.clearInputs()      
                });
            }
       },
       editProjectRecord(projectID) {
             axios.get(`http://localhost:8000/api/projects/${projectID}/edit`).then(
                response => {
                    console.log(response)
                    this.projectIdToUpdate = response.data[0].project_id;
                    this.input.dateOfProject = response.data[0].date_of_project;
                    this.input.grade = response.data[0].grade;
                  
                }
            );
       },
       removeProjectRecord(projectID) {
            if(confirm('Are you sure to delete this record? ')){
                axios.delete(`http://localhost:8000/api/projects/${projectID}`).then(
                    response => {
                        this.message = response.data;
                        this.refreshList()
                    }
                );
            }
       },
       refreshList() {
            axios.get(`http://localhost:8000/api/fetchprojects/${this.input.student_lrn}`).then(
            response => {
                this.projectRecords = response.data.projectRecords;
                this.projectData = response.data.projectData;
            })
       },
       clearInputs() {
           this.input.dateOfProject = '';
           this.input.grade = '';
       }
      
    }

}
</script>

<style scoped>

</style>