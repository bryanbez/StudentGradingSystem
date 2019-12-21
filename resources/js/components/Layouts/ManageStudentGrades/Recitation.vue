<template>
    <div>

        <div class="container">
            <div class="col-md-12 col-lg-12">
               <br />
                <div class="alert alert-info" v-if="message != ''">
                        <p> {{ message }}  <a style="float: right; cursor: pointer" @click="dismissMessage()">X</a></p>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
                    </div>           
               <br />
                <h3>Recitations of {{ studentFullName }}</h3>
                <hr />
                <h5 v-if="recitationRecords != null"> Total Recitation: {{ overAllRecitationRecord.recitation_count }} </h5>
                <hr />
                <h4>Add/ Update Recitation Records</h4>

                    <form @submit.prevent="saveOrUpdateProjectRecord">
                    <table class="table table-bordered">
                        <tr>
                            <th> Date Given</th>
                            <th> points </th>
                            <th colspan="2"> Options</th>
                        </tr>
                        <tr >
                            <td> <input type="date" class="form-control" v-model="input.dateOfRecitation"> </td>
                            <td> <input type="text" class="form-control" v-model="input.points"> </td>
                            <td> <button class="btn btn-primary" type="submit">Save</button> </td>  
                        </tr>
                    </table>
                    </form>
                     <td> <button class="btn btn-primary" @click="clearInputs()">Clear</button> </td>
                    <br />
                 
                 
                    <table class="table table-bordered" v-if="recitationRecords != null">
                        <tr>
                            <th> Date Given</th>
                            <th> Points </th>
                            <th colspan="2"> Options </th>
                        </tr>
                        <tr v-for="singleRecitationRecord in recitationRecords" :key="singleRecitationRecord.recitation_id">
                            <td> {{ singleRecitationRecord.date_of_recitation }}  </td>
                            <td> {{ singleRecitationRecord.points }}  </td>
                            <td> <button class="btn btn-primary" @click="editRecitationRecord(singleRecitationRecord.recitation_id)">Edit</button> </td>
                            <td> <button class="btn btn-danger" @click="removeProjectRecord(singleRecitationRecord.recitation_id)">Remove</button></td>
                        </tr>
                        <tr>
                            <td> Final Grade: </td>
                            <td colspan="3">{{ overAllRecitationRecord.equivalent }}</td>
                        </tr>
                    </table>

                    <p id="noResult" v-else> No Recitation Records </p>

                    <br />

                    <router-link v-bind:to="{name: 'managestudentgrades', params:{student_lrn: input.student_lrn, student_year: schoolYr, subject_code: input.subj_code}}" class="btn btn-danger">Back</router-link>
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
                dateOfRecitation: '',
                subj_code: '',
                points: '',
            },
            recitationIdToUpdate: '',
            recitationRecords: [],
            overAllRecitationRecord: [],
            studentFullName: '',
            message: '',
            subj_name: '',
            schoolYr: ''
        }
    },
    created() {
         this.input.student_lrn = this.$route.params.student_lrn;
         this.input.subj_code = this.$route.params.subject_code;
         this.schoolYr = this.$route.params.student_year;
         console.log(this.input.student_lrn + '/ Recitation /' + this.input.subj_code)

        axios.get('http://localhost:8000/api/student/'+this.input.student_lrn)
            .then(response => {
             this.studentFullName = response.data[0].studentLastName + ', ' + response.data[0].studentFirstName;
        });

        axios.get(`http://localhost:8000/api/subject/${this.input.subj_code}`).then(
            response => {
               this.subj_name = response.data[0].subj_name;
        });

        this.refreshList()

    },
    methods: {
       saveOrUpdateProjectRecord() {
             if(this.recitationIdToUpdate != '') {
                axios.put(`http://localhost:8000/api/recitation/${this.recitationIdToUpdate}`, this.input).then(
                    response => {
                    console.log(response)
                    this.recitationIdToUpdate = ''
                    this.refreshList()
                    this.clearInputs()
                });
            }
            else {
                axios.post('http://localhost:8000/api/recitation', this.input).then(
                    response => {
                    console.log(response)
                    this.refreshList()
                    this.clearInputs()      
                });
            }
       },
       editRecitationRecord(recitationID) {
             axios.get(`http://localhost:8000/api/recitation/${recitationID}/edit`).then(
                response => {
                    console.log(response)
                    this.recitationIdToUpdate = response.data[0].recitation_id;
                    this.input.dateOfRecitation = response.data[0].date_of_recitation;
                    this.input.points = response.data[0].points;
                  
                }
            );
       },
       removeProjectRecord(recitationID) {
            if(confirm('Are you sure to delete this record? ')){
                axios.delete(`http://localhost:8000/api/recitation/${recitationID}`).then(
                    response => {
                        console.log(response)
                        this.refreshList();
                    }
                );
            }
       },
       refreshList() {
            axios.get(`http://localhost:8000/api/fetchrecitation/${this.input.student_lrn}/${this.input.subj_code}`).then(
                response => {
                    console.log(response)
                    if (response.data.overAllRecitationResult.length == 0) {
                        this.recitationRecords = null;
                    }
                    else {
                        this.recitationRecords = response.data.recitationRecords;
                        this.overAllRecitationRecord = response.data.overAllRecitationResult[0];
                    }
            })
       },
       clearInputs() {
           this.input.dateOfRecitation = '';
           this.input.points = '';
       }
      
    }

}
</script>

<style scoped>
#noResult {
    font-weight: bold;
    font-size: 14px;
}
</style>