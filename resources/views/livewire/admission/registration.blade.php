<div class="container-fluid">
    <div class="row">
        <div class="col">
            
            @include('livewire.admission.create')
            @include('livewire.admission.update')    
            @include('livewire.admission.show')
            
            <div class="card card-accent-success">
                <div class="card-header">Admission
                    <div class="card-header-actions">
                        <a class="card-header-action btn-setting" href="#" wire:click="resetInput" data-toggle="modal" data-target="#formCreateModal">
                            <i class="c-icon cil-pen-alt c-sidebar-nav-icon"></i> Registration
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-7">
                            <input wire:model.debounce.300ms="search" class="form-control" type="search" placeholder="Search...">
                        </div>
                        <div class="col-2">
                            <select wire:model="orderBy" class="form-control"  id="grid-state">
                                <option value="id">ID</option>
                                <option value="first_name">First Name</option>
                                <option value="last_name">Last Name</option>
                                <option value="email">Email</option>
                                <option value="admission_date">Admission Date</option>
                                <option value="created_at">Date Created</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <select wire:model="orderAsc" class="form-control" id="grid-state">
                                <option value="1">Ascending</option>
                                <option value="0">Descending</option>
                            </select>
                        </div>
                        <div class="col">
                            <select wire:model="perPage" class="form-control" id="grid-state">
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                                <option>100</option>
                            </select>
                        </div>
                    </div>
            
                    <!-- ********************************************************************************** -->
                    <!-- *** Start: User Registration -->
                    <!-- ********************************************************************************** -->
            
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th nowrap>#</th>
                                <th nowrap>Status</th>
                                <th nowrap>Name</th>
                                <th nowrap>Email</th>
                                <th nowrap>Admission Date</th>
                                <th nowrap>Classifications</th>
                                <th nowrap>Level/Program/Course</th>
                                <th nowrap>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($admission as $student)
                                <tr>
                                    {{--<th>{{ ++$i }}</th>--}}
                                    <th>{{ (($admission->currentPage() * $admission->perPage()) - $admission->perPage()) + $loop->iteration  }}</th>
                                    <td>{{$student->StudentStatus['description']}}</td>
                                    <td>{{ $student->full_name}}</td>
                                    {{--<td>{{ $student->student['email']}}</td>--}}
                                    <td>{{ $student->email}}</td>
                                    <td>{{ $student->admission_date_name }}</td>
                                    <td>{{ $student->course['classification']['description']}}</td>
                                    <td>{{ $student->course['code'] }}</td>
                                    <td>
                                        {{--<a wire:click="edit({{$student->id}})" class="dropdown-item"><i class="cil-pencil"></i>&nbsp;Edit</a>--}}
                                        {{--<a wire:click="destroy({{$student->id}})" class="dropdown-item"><i class="cil-trash"></i>&nbsp;Delete</a>--}}
                                        {{--@if(empty($student->enrolment) && $student->creditedsubject->count() <= 0 )--}}
                                        @if(empty($student->enrolment) && $student->creditedsubject->count() <= 0 )
                                            <button wire:click="edit({{$student->id}})" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#formUpdateModal"><i class="cil-pencil"></i>&nbsp;Edit</button>
                                            {{--<button x-on:click="return confirm('Are you sure?') ? @this.destroy({{$student->id}}) : false" class="btn btn-sm btn-danger"><i class="cil-trash"></i>&nbspDelete</button>--}}
                                            <button type="button" wire:click="deleteId({{ $student->id }})" data-toggle="modal" data-target="#deleteModal" class="btn btn-sm btn-danger"><i class="cil-trash"></i>&nbsp;Delete</button>
                                        @else
                                            <button wire:click="show({{$student->id}})" class="btn btn-sm btn-primary px-4" data-toggle="modal" data-target="#formShowModal" data-bs-dismiss="modal"><i class="cil-notes"></i>&nbsp;View Details</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $admission->links() !!}
                    </div>
            
                    <!-- ********************************************************************************** -->
                    <!-- *** End: User Registration -->
                    <!-- ********************************************************************************** -->
            
                    <!-- Begin: Modal Confirmation -->
                    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirm</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true close-btn">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure want to delete?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                                    <button type="button" wire:click.prevent="delete()" class="btn btn-danger close-modal" data-dismiss="modal">Yes, Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End: Modal Confirmation -->
            
                </div>
            </div>


        </div>
    </div>
</div>
