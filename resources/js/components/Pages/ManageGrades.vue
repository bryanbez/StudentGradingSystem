<template>
    <div class="container">
        <br />
        <h3>Manage Student Grades </h3>
        <br />
        <hr />

        <div class="row">
            <div class="col-md-6 col-lg-6">
                <div class="row">
                   <table>
                       <tr>
                           <td>
                            <select v-model="sltLrnYear" @change="sortByYearAndSection" class="form-control">
                                <option value="" disabled selected>Select Year</option>
                                <option v-for="fetchYear in studentYear" :key="fetchYear.Year"> {{ fetchYear.Year }}</option>
                            </select>
                           </td>
                           <td>
                            <select v-model="sltLrnSection" @change="sortByYearAndSection" class="form-control">
                                <option value="" disabled selected>Select Section</option>
                                <option v-for="fetchSection in studentSection" :key="fetchSection.section"> {{ fetchSection.section }}</option>
                            </select>
                           </td>
                           <td>
                             <button class="btn btn-info" @click="defaultList">Clear Sort</button>
                           </td>
                       </tr>
                   </table>            
              
                </div>
            </div>
             <div class="col-md-3 col-lg-3">
                    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addStudentInfo"> Add Student </button>
             </div>
              <div class="col-md-3 col-lg-3">
                  <input type="text" class="form-control" @keyup="searchStudentName" v-model="searchText" placeholder="Search Student">
              </div>
        </div>

         
        <div class="row float-right">
            <table>
                <tr>
                    <td>
                        <button class="btn btn-info" :disabled='isFirst' @click="paginationFirstPage">First</button>
                    </td>
                    <td>
                        <button class="btn btn-info" :disabled='isPrev' @click="paginationPreviousPage">Prev</button>
                    </td>
                    <td>    
                        <h5><center> Page {{ pagination.currPage }} of {{ pagination.lastPage }}</center></h5>
                    </td>
                    <td>
                        <button class="btn btn-info" :disabled='isNext' @click="paginationNextPage">Next</button>
                    </td>
                    <td>
                        <button class="btn btn-info" :disabled='isLast' @click="paginationLastPage">Last</button>
                    </td>
                </tr>
            </table>
        </div>
            

        <table class="table table-bordered" v-if="studentList != ''">
            <tr>
                <th>Student Name</th>
                <th>Student Year</th>
                <th>Student Section</th>
                <th colspan="3"><center> Options </center></th>
            </tr>
            <tr v-for="singleStudent in studentList" :key="singleStudent.student_lrn">
                <td> {{ singleStudent.studentLastName + ', ' + singleStudent.studentFirstName + ' ' + singleStudent.studentMiddleName  }} </td>
                <td> {{ singleStudent.schoolYear | schoolYear }} </td>
                <td> {{ singleStudent.section }}</td>
                <td><router-link v-bind:to="{name: 'viewstudent', params:{student_lrn: singleStudent.student_lrn}}" class="btn btn-primary"> View Information </router-link></td>
                <td><router-link v-bind:to="{name: 'managestudentsubjectgrades', params:{student_lrn: singleStudent.student_lrn, student_year: singleStudent.schoolYear}}" class="btn btn-secondary"> View Grades </router-link></td>
            </tr>

        </table>

        <h4 v-else> No Result Found</h4>

            <div class="modal fade" id="addStudentInfo" tab-index="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                           <h4> Add Student </h4>
                        </div>
                        <div class="modal-body">
                            <AddStudent @refreshList="refreshStudentList"></AddStudent>
                        </div>
                        <div class="modal-footer">
                              <button class="btn btn-danger" data-dismiss="modal"> Close </button>
                        </div>
                    </div>
                </div>
            </div>

        
    </div>
</template>

<script>
import AllCritea from '../Layouts/ManageStudentGrades/AllCritea';
import AddStudent from '../Layouts/ManageStudentGrades/AddStudent';

export default {
    components: {
        AllCritea,
        AddStudent
    },
    data: function() {
        return {
            studentList: [],
            studentYear: [],
            studentSection: [],
            sltLrnYear: '',
            sltLrnSection: '',
            pagination: {
                prevURL: '',
                nextURL: '',
                firstURL: '',
                lastURL: '',
                currPage: '',
                lastPage: '',
            },
            isPrev: false,
            isNext: false,
            isLast: false,
            isFirst: false,
            searchText: ''
        }
    },
    created() {
        axios.get('http://localhost:8000/api/students')
            .then(response => {
                console.log(response)
                this.paginationDatas(response);
                 this.isPrev = true;
                 this.isFirst = true;
                 if(response.data.next_page_url === null) {
                      this.isLast = true;
                      this.isNext = true;
                 }
        });
        axios.get('http://localhost:8000/api/fetchStudentYearInLRN')
             .then(response => {
                 console.log(response)
                 this.studentYear = response.data;
        });  
        axios.get('http://localhost:8000/api/fetchStudentSection')
             .then(response => {
                 console.log(response)
                 this.studentSection = response.data;
        });  
    },
    methods: {
        sortByYearAndSection() {

            if(this.sltLrnSection == '') {
                axios.get(`http://localhost:8000/api/fetchStudentsBaseInYearLRN/${this.sltLrnYear}/NULL`)
                    .then(response => {
                            console.log(response);
                            //this.studentList = response.data;
                            this.paginationDatas(response);
                            this.isPrev = true;
                            this.isFirst = true;
                            this.isLast = false;
                            this.isNext = false;
                            if(response.data.next_page_url === null) {
                                this.isLast = true;
                                this.isNext = true;
                    }
                });
            }
            else {
                axios.get(`http://localhost:8000/api/fetchStudentsBaseInYearLRN/${this.sltLrnYear}/${this.sltLrnSection}`)
                    .then(response => {
                        console.log(response);
                        //this.studentList = response.data;
                        this.paginationDatas(response);
                        this.isPrev = true;
                        this.isFirst = true;
                        this.isLast = false;
                        this.isNext = false;
                        if(response.data.next_page_url === null) {
                            this.isLast = true;
                            this.isNext = true;
                    }
                });
            }
          
        },
        defaultList() {
            axios.get('http://localhost:8000/api/students')
                .then(response => {
                    console.log(response)
                    this.paginationDatas(response);
                    this.isPrev = true;
                    this.isFirst = true;
                    this.isLast = false;
                    this.isNext = false;
                    if(response.data.next_page_url === null) {
                        this.isLast = true;
                        this.isNext = true;
                    }
                    this.sltLrnYear = '';
                    this.sltLrnSection = '';
            });
        },
        paginationNextPage() {
            axios.get(this.pagination.nextURL)
                .then(response => {
                    this.paginationDatas(response);
                  
                    if(response.data.next_page_url === null) {
                        this.isLast = true;
                        this.isNext = true;
                    }

                    this.isFirst = false;
                    this.isPrev = false;
                
            });
        },
        paginationPreviousPage() {
            axios.get(this.pagination.prevURL)
                .then(response => {
                    this.paginationDatas(response);

                    if(response.data.prev_page_url === null) {
                        this.isFirst = true;
                        this.isPrev = true;
                    }

                    this.isNext = false;
                    this.isLast = false;
                 
            });
        },
        paginationFirstPage() {
            axios.get(this.pagination.firstURL)
                .then(response => {
                   this.paginationDatas(response);

                    if(response.data.prev_page_url === null) {
                        this.isFirst = true;
                        this.isPrev = true;
                    }

                    this.isNext = false;
                    this.isLast = false;
                  
            });

        },
        paginationLastPage() {
             axios.get(this.pagination.lastURL)
                .then(response => {
                   this.paginationDatas(response);

                    if(response.data.next_page_url === null) {
                        this.isLast = true;
                        this.isNext = true;
                    }

                    this.isFirst = false;
                    this.isPrev = false;
            });

        },
        searchStudentName() {

            if(this.searchText == '') {
                return this.defaultList();
            }
            else {
                 axios.get(`http://localhost:8000/api/students/search/${this.searchText}`)
                    .then(response => {
                      this.paginationDatas(response);
                });
            }
           
        },
        paginationDatas(response) {
            this.studentList = response.data.data;
            this.pagination.currPage = response.data.current_page;
            this.pagination.lastPage = response.data.last_page;
            this.pagination.firstURL = response.data.first_page_url;
            this.pagination.lastURL = response.data.last_page_url;
            this.pagination.nextURL = response.data.next_page_url;
            this.pagination.prevURL = response.data.prev_page_url;
        },
        refreshStudentList(value) {
            if (value == 200) {
                this.defaultList();
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