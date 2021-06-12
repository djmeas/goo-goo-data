<template>
  <div id="child-view-page-container">
    <div v-if="child" class="row">
      <div class="col-lg-4 offset-lg-4 mb-5">
        <div class="text-center">
          <div class="child-img position-relative">
            <img class="child-hero-img rounded-circle mb-4 animate__bounceIn" :src="`${$baseAvatarPath}/${child.image_path}`" alt="" width="100%">
            <transition name="fade">
              <div v-if="isParentOfChild" class="parent-icon">
                <span class="material-icons" style="font-size:64px">
                  escalator_warning
                </span>
              </div>
            </transition>
          </div>
          <h1>{{child.first_name}} {{child.last_name}}</h1>
          <h3><span class="material-icons">cake</span> {{child.birthday | dateFormatBirthday}}</h3>
          <h3 class="mb-4">{{$childBirthdayInMonths(child.birthday)}}</h3>
          <div class="btn-group">
            <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Manage
            </button>
            <div class="dropdown-menu">
              <a class="dropdown-item clickable">Edit details</a>
              <a class="dropdown-item clickable" @click="markChildParent(child.id)">
                {{isParentOfChild ? 'Unmark' : 'Mark'}} as my child
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Caretakers -->
      <div class="col-lg-12">
        <page-header-text text="Caretakers"/>
      </div>

      <template v-if="!isAddingCaretaker && caretakers.length > 0">
        <div v-for="caretaker in caretakers" class="col-lg-4 mb-5">
          <div class="card-horizontal">
            <div class="left-box">
              <span class="material-icons">
                account_circle
              </span>
            </div>
            <div class="right-box">
              <h1>{{caretaker.first_name}} {{caretaker.last_name}}</h1>
              <h2>{{caretaker.role}}</h2>
            </div>
            <div v-if="$currentUser.id !== caretaker.id" class="action-box">
              <div class="icon clickable" @click="removeCaretaker(childhash, caretaker)">
                <span class="material-icons">
                delete
                </span>
              </div>
            </div>
          </div>
        </div>

        <div v-for="invite in pendingInvites" class="col-lg-4 mb-5">
          <div class="card-horizontal">
            <div class="left-box">
              <span class="material-icons">
                account_circle
              </span>
              <div class="pending">Pending</div>
            </div>
            <div class="right-box">
              <h1>{{invite.email}}</h1>
              <h2>{{invite.role}}</h2>
            </div>
            <div class="action-box">
              <div class="icon clickable" @click="deleteInvite(invite, childhash)">
                <span class="material-icons">
                delete
                </span>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 mb-5 clickable" @click="isAddingCaretaker = true">
          <div class="card-horizontal">
            <div class="left-box">
              <span class="material-icons">
                person_add
              </span>
            </div>
            <div class="right-box">
              <h1>Add New Caretaker</h1>
            </div>
          </div>
        </div>
      </template>

      <transition name="fade_in_only">
        <div v-if="isAddingCaretaker" class="col-lg-12">
          <caretaker-add-form-component 
          :childHash="childhash"
          v-on:emitSaveInvite="getPendingInvites(childhash);isAddingCaretaker = false;">
            <button class="btn btn-default" @click="isAddingCaretaker = false">Cancel</button>
          </caretaker-add-form-component>
        </div>
      </transition>
      
      <div class="col-lg-12">
        <tracker-table-component :childhash="childhash"/>
      </div>

    </div>
  </div>
</template>

<script>
import childrenMixin from '../../mixins/children';
import caretakersMixin from '../../mixins/caretakers';

export default {
  data() {
    return {
      isAddingCaretaker: false,
      isParentOfChild: false
    }
  },
  props: {
    childhash: {
      type: String,
      required: false,
      default: null
    }
  },

  mixins: [
    childrenMixin,
    caretakersMixin
  ],

  methods: {

  },

  mounted() {
    this.getChildren(this.childhash);
    this.getCaretakers(this.childhash);
    this.getPendingInvites(this.childhash);
    this.getIsParentOfChild(this.childhash, Vue.prototype.$currentUser.id);
  }
}
</script>

<style>

</style>