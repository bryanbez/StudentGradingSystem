<template>
    <div class="container">

        <br />
        <h3>Manage Subjects </h3>
        <br />
        <hr />

        <div class="row">

            <div class="col-md-12 col-lg-12">
                <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addSubject"> Add Subject </button>
            </div>

            <div class="col-md-12 col-lg-12">
               <table class="table table-default">
                   <tr>
                       <th>Subject Code</th>
                       <th>Subject For Year</th>
                       <th>Subject Name</th>
                       <th>Subject Description</th>
                       <th colspan="2">Options</th>
                   </tr>
                   <tr v-for="fetchSubject in subjectsInfo" :key="fetchSubject.subj_code">
                        <td> {{ fetchSubject.subj_code }} </td>
                        <td> {{ fetchSubject.subj_for_yr }} </td>
                        <td> {{ fetchSubject.subj_name }} </td>
                        <td> {{ fetchSubject.subj_description }} </td>
                        <td><button class="btn btn-primary mb-3" data-toggle="modal" data-target="#updateSubject" @click="putSubjectData(fetchSubject.subj_code)"> Edit Subject </button></td>
                        <td><button class="btn btn-danger" @click="deleteSubject(fetchSubject.subj_code)">Delete</button></td>

                   </tr>
               </table>
            </div>


        </div>
        

        <div class="modal fade" id="addSubject" tab-index="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                           <h4> Add Subject </h4>
                        </div>
                        <div class="modal-body">
                            <AddSubject @refreshList="updateList"></AddSubject>
                        </div>
                        <div class="modal-footer">
                              <button class="btn btn-danger" data-dismiss="modal" @click="closeMsg"> Close </button>
                        </div>
                    </div>
                </div>
        </div>

         <div class="modal fade" id="updateSubject" tab-index="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                           <h4> Update Subject </h4>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <form @submit.prevent="updateSubject">
                                <div class="alert alert-info" v-if="statusOfUpdate === 200">
                                        {{ insertMsg }}
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                    <label for="">Subject Code</label>
                                    <input class="form-control" type="text" disabled v-model="subjectInfoToUpdate.txtSubjCode" />  
                                </div>
                                 <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                    <label for="">Subject for Year</label>
                                    <select v-model="subjectInfoToUpdate.sltLrnYear" class="form-control">
                                        <!-- <option value="" disabled selected>Select Year</option> -->
                                        <option v-for="fetchYear in studentYear" :key="fetchYear.Year" selected> {{ fetchYear.Year | schoolYear }}</option>
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                    <label for="">Subject Name</label>
                                    <input class="form-control" type="text" v-model="subjectInfoToUpdate.txtSubjName" />
                                    <span v-if="insertMsg.txtSubjName" class="error"> {{ insertMsg.txtSubjName | trimCharacters }}</span>   
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                    <label for="">Subject Description</label>
                                    <textarea class="form-control" type="text" v-model="subjectInfoToUpdate.txtSubjDesc" rows="10">  </textarea>
                                    <span v-if="insertMsg.txtSubjDesc" class="error"> {{ insertMsg.txtSubjDesc | trimCharacters }}</span>
                                </div>

                                <div class="col-md-12 col-lg-12 mt-5">
                                    <button type="submit" class="btn btn-primary">Update Subject</button>
                                </div>
                            </form>

                            </div>
                        </div>
                        <div class="modal-footer">
                              <button class="btn btn-danger" data-dismiss="modal" @click="closeMsg"> Close </button>
                        </div>
                    </div>
            </div>

        </div>

    </div>
</template>

<script>

import AddSubject from './AddSubjectForm';

export default {
    components: {
        AddSubject
    },
    data() {
        return {

            subjectsInfo: [],
            studentYear: [],
            statusOfUpdate: '',
            insertMsg: '',
            subjectInfoToUpdate: {
                sltLrnYear: '',
                txtSubjName: '',
                txtSubjDesc: ''
            },
        }
    },
    created() {
        axios.get('http://localhost:8000/api/subject').then(
            response => {
                this.subjectsInfo = response.data.data;
        });
        axios.get('http://localhost:8000/api/fetchStudentYearInLRN')
             .then(response => {
                 console.log(response)
                 this.studentYear = response.data;
        });  
    },
    methods: {
        updateSubject() {
            axios.put(`http://localhost:8000/api/subject/${this.subjectInfoToUpdate.txtSubjCode}`, this.subjectInfoToUpdate).then(
                response => {
                    console.log(response)
                    this.insertMsg = response.data.original;
                    this.statusOfUpdate = response.status;
                    this.clearTextbox()
                    this.refreshList()

            }).catch(error => {
                 this.statusOfUpdate = error.response.status;
                 this.insertMsg = error.response.data.errors;
            });
        },
        clearTextbox() {
            this.subjectInfoToUpdate.txtSubjCode = '';
            this.subjectInfoToUpdate.sltLrnYear = '';
            this.subjectInfoToUpdate.txtSubjName = '';
            this.subjectInfoToUpdate.txtSubjDesc = '';
        },
        putSubjectData(subj_code) {
            axios.get(`http://localhost:8000/api/subject/${subj_code}`).then(
                response => {
                    console.log(response);
                    this.subjectInfoToUpdate.txtSubjCode = response.data[0].subj_code;
                    this.subjectInfoToUpdate.sltLrnYear = response.data[0].subj_for_yr;
                    this.subjectInfoToUpdate.txtSubjName = response.data[0].subj_name;
                    this.subjectInfoToUpdate.txtSubjDesc = response.data[0].subj_description;

            });
        },
        deleteSubject(subj_code) {
            if (confirm('Are you sure to delete this subject?')) {
                axios.delete(`http://localhost:8000/api/subject/${subj_code}`).then(
                    response => {
                        console.log(response);
                        alert('Subject Deleted');
                        this.refreshList()
                });
            
            }
        },
        refreshList() {
            axios.get('http://localhost:8000/api/subject').then(
                response => {
                    this.subjectsInfo = response.data.data;
            });
        },
        closeMsg() {
            this.statusOfUpdate = '';
            this.clearTextbox()
        },
        updateList(value) {
            if(value == 200) {
                this.refreshList();
            }
        }
    },
    filters: {
         schoolYear(value) {
            if (value == 1) {
                return '1st';
            }
            else if(value == 2) {
                return '2nd';
            }
            else if(value == 3) {
                return '3rd';
            }
            else if (value == 4) {
                return '4th';
            }
            else {
                // Null
            }
        }
    }
  
  
}
</script>

<style scoped>

</style>