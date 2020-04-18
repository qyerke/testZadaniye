<template>
    <div class="container">
        <nav class="navbar navbar-light bg-light">
    <form class="form-inline">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" v-model="search" >
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary my-2 my-sm-0" data-toggle="modal" data-target="#exampleModal">
        Filter
        </button>
    </form>
    </nav>
          <div class="row justify-content-center">
                    <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Deadline</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="todo in filteredList"  :key="todo.id">
                        <th scope="row">{{todo.id}}</th>
                        <td>{{todo.title}}</td>
                        <td>{{todo.deadline}}</td>
                        </tr>
                    </tbody>
                    </table>
            </div>

        <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Filter Form</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>

            <div class="form-group">
                <label for="title">Название</label>
                <textarea class="form-control" id="title" rows="2" name="title" v-model="filter.selectedTitle"></textarea>
            </div>

            <div class="form-group">
            <label >Постановщик</label>
            <multiselect v-model="filter.selectedOwner" track-by="name" label="name" placeholder="Select one" :options="owners" :searchable="false" :allow-empty="false"  name="selectedOwner">
                <template ><strong>{{ owners.name }}</strong> </template>
            </multiselect>
            </div>

            <div class="form-group">
            <label for="">Ответственный</label>
            <multiselect v-model="filter.selectedUsers"  :taggable="true" :multiple="true" track-by="name" label="name" placeholder="Select one" :options="users" :searchable="false" :allow-empty="false" name="selectedUsers">
                <template ><strong>{{ users.name }}</strong> </template>
            </multiselect>
            </div>

           <div class="form-group">
            <label for="">Статус</label>
            <multiselect v-model="filter.selectedStatus"   :multiple="true"  placeholder="Select one" :options="statusses"  name="selectedStatus">
            </multiselect>
            </div>
 

            <div class="form-group">
            <label for="example-date-input" class="col-2 col-form-label">Date</label>
            <div class="col-10">
                <input class="form-control" type="date" id="example-date-input" name="date" v-model="filter.selectedDate">
            </div>

            </div>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" v-on:click="sendForm">Save changes</button>
            </form>
        </div>
        </div>
    </div>
    </div>


    </div>
</template>
<script>
import Multiselect from 'vue-multiselect'
import axios from 'axios'
    export default {
        components: { Multiselect },
        data() {
            return {
            filter: {           
                selectedStatus: '',
                selectedDate: '',
                selectedOwner: '',
                selectedUsers: '',
                selectedTitle: ''
            },
            statusses: [],
            options: [],
            todos: [],
            title: '',
            search: '',
            owners: [],
            users: [],
            }
        },
        mounted() {
           this.getTasks(),
           this.getStatuses(),
           this.getOwners(),
           this.getUsers()
        },
        methods: {
            getTasks() {
                axios.get('/api/tasks').then(
                    result => {
                        this.todos = result.data
                    }
                )
            }, 
            getStatuses() {
                axios.get('/api/taskStatuses').then(
                     result => {
                        this.statusses = result.data
                        console.log(this.statusses)
                    }
                )
            },
            getOwners(){
               axios.get('/api/getOwners').then(
                     result => {
                        this.owners = result.data
                    }
                )     
            },
            getUsers(){
               axios.get('/api/getUsers').then(
                     result => {
                        this.users = result.data
                    }
                )     
            },
            sendForm(){
                console.log(this.filter)
                axios.post('/api/search', this.filter).then(
                     result => {
                         this.todos = result.data
                         this.reset()
                         $('#exampleModal').modal('hide');
                    })
            },
            reset () {
                        this.filter =  [
                            {
                               selectedStatus: null,
                                selectedDate: null,
                                selectedOwner: null,
                                selectedUsers: null,
                                selectedTitle: null
                            }
                        ]
            },
        },
        computed: {
            filteredList() {
            return this.todos.filter(todo => {
                //this.filter.owner = todo.user.name
                console.log(todo)
                return todo.title.toLowerCase().includes(this.search.toLowerCase())
                
            })
        }
        },
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>