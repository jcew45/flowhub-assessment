<script setup>
import { ref, onMounted, getCurrentInstance } from 'vue';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import SplitButton from 'primevue/splitbutton';
import Editor from 'primevue/editor';
import MultiSelect from 'primevue/multiselect';
import Dropdown from 'primevue/dropdown';
import Calendar from 'primevue/calendar';
import FileUpload from 'primevue/fileupload';

import '../../css/flag.css'

const { emit } = getCurrentInstance();

onMounted(() => {
  const itemList = ref([
    { label: 'Post' }, 
    { label: 'Add Post' }
    ]);
  emit('assignBreadCrumbs', itemList.value);
});

const postDatabody = ref(
  {
    title: "",
    excerpt: "",
    content: "",
    tags: ref(),
    url: "",
    seo_title: "",
    seo_desciption: ""
  }
)

const tagsOption = ref([
    { name: 'Food', value: 'food' },
    { name: 'Photography', value: 'photography' },
    { name: 'Travel', value: 'travel' },
    { name: 'Fashion', value: 'fashion' },
    { name: 'Film', value: 'film' },
    { name: 'Gaming', value: 'gaming' },
    { name: 'Art & Design', value: 'art_and_design' }
]);

const actionOptions = [
    {
        label: 'Update',
        command: () => {
            toast.add({ severity: 'success', summary: 'Updated', detail: 'Data Updated', life: 3000 });
        }
    },
    {
        label: 'Delete',
        command: () => {
            toast.add({ severity: 'warn', summary: 'Delete', detail: 'Data Deleted', life: 3000 });
        }
    },
    {
        label: 'Vue Website',
        command: () => {
            window.location.href = 'https://vuejs.org/';
        }
    },
    { label: 'Upload', to: '/fileupload' }
];

const selectedStatus = ref()
const statusOptions = ref([
  { label: 'Published', code: 'NY' },
  { label: 'Draft', code: 'RM' },
])

const selectedCategory = ref()

const startDate = ref()
const startTime = ref()
const endDate = ref()
const endTime = ref()

const selectedLanguage = ref();
const countries = ref([
    { name: 'English', code: 'US' },
    { name: 'Chinese', code: 'CN' },
    { name: 'Australia', code: 'AU' },
    { name: 'Brazil', code: 'BR' },
    { name: 'Egypt', code: 'EG' },
    { name: 'France', code: 'FR' },
    { name: 'Germany', code: 'DE' },
    { name: 'India', code: 'IN' },
    { name: 'Japan', code: 'JP' },
    { name: 'Spain', code: 'ES' },
]);
const translation = ref()

import { onBeforeRouteLeave } from 'vue-router'
import ConfirmDialog  from 'primevue/confirmdialog';
import { useConfirm } from "primevue/useconfirm";

const confirm = useConfirm();
onBeforeRouteLeave((to, from, next) => {
    promptNavigationConfirm(next);
})

  const promptNavigationConfirm = async (next) => {
    await confirm.require({
        group: 'beforeNavigate',
        header: "",
        messageL1: 'The changes you made will be lost if you navigate away from this page.',
        messageL2: 'Are you sure you want to leave this page?',
        icon: 'pi pi-exclamation-circle',
        // acceptIcon: 'pi pi-check',
        // rejectIcon: 'pi pi-times',
        rejectClass: 'reject-btn p-button-outlined p-button-sm',
        acceptClass: 'accept-btn p-button-sm',
        rejectLabel: 'Leave this Page',
        acceptLabel: 'Stay on this page',
        accept: () => {
          return false
        },
        reject: () => {
          next()
        }
    });
  }
</script>

<template>
    <div class="post-add">
      <div class="left">
        <div class="form-card">
          <div class="input-wrapper spacing">
              <label for="title"><span class="label-required">* </span>Title</label>
              <InputText id="title" v-model="postDatabody.title" placeholder="Please enter your title..." />
          </div>
          <div class="input-wrapper">
              <label for="excerpt">Excerpt</label>
              <Textarea id="excerpt" v-model="postDatabody.excerpt" rows="5" cols="30" placeholder="Please enter your content here..." />
          </div>
        </div>
        <div class="form-card">
          <div class="input-wrapper spacing">
              <label for="contentEditor"><span class="label-required">* </span>Content</label>
              <Editor id="contentEditor" v-model="postDatabody.content" editorStyle="height: 320px" />
          </div>
          <div class="input-wrapper">
            <label for="tagSelect">Post Tag</label>
            <MultiSelect id="tagSelect" v-model="postDatabody.tags" :options="tagsOption" optionLabel="name" placeholder="Hit and enter tag here."
             class="w-full md:w-20rem" />
          </div>
        </div>
        <div class="bottom-form">
          <div class="form-title">
            Meta Description (SEO)
          </div>
          <div class="form-card">
            <div class="input-wrapper spacing">
                <label for="url"><span class="label-required">* </span>URL Handle</label>
                <InputText id="url" v-model="postDatabody.url" placeholder="Please enter your url handle..." />
                <div class="copy-url"><small>
                  <a :href="`https://website.com/blogs/${postDatabody.url}`">{{ `https://website.com/blogs/${postDatabody.url}` }}</a>
                  <span class="pi pi-copy"></span>
                </small></div>
            </div>
            <div class="input-wrapper spacing">
                <label for="url">Page Title</label>
                <InputText id="url" v-model="postDatabody.seo_title" placeholder="Please enter your page title..." />
            </div>
            <div class="input-wrapper">
                <label for="url">Page Description</label>
                <Textarea id="excerpt" v-model="postDatabody.seo_desciption" rows="5" cols="30" placeholder="Please enter your page description..." />
            </div>
          </div>
        </div>
      </div>
      <div class="right">
        <button class="preview-btn" type="button">
          <span class="pi pi-eye"></span>
          <span>Preview</span>
        </button>
        <SplitButton class="publish-btn" label="Publish" :model="actionOptions" outlined></SplitButton>
        <div class="form-card">
          <div class="card-title">
            Publish Status
          </div>
          <Dropdown v-model="selectedStatus" :options="statusOptions" optionLabel="label" placeholder="Please select" class="status-select" filled />
        </div>
        <div class="form-card">
          <div class="card-title">
            Schedule Start Date
          </div>
          <div class="date-wrapper first">    
            Start Date      
            <Calendar v-model="startDate" showIcon iconDisplay="input" placeholder="Select Date" />
            <Calendar id="calendar-timeonly" v-model="startTime" timeOnly placeholder="Select Time" />
          </div>
          <div class="date-wrapper">    
            End Date      
            <Calendar v-model="endDate" showIcon iconDisplay="input" placeholder="Select Date" />
            <Calendar id="calendar-timeonly" v-model="endTime" timeOnly placeholder="Select Time" />
          </div>
        </div>
        <div class="form-card">
          <div class="card-title">
            Category
          </div>
          <Dropdown v-model="selectedCategory" editable :options="statusOptions" optionLabel="label" placeholder="Choose or enter here" class="status-select" filled />
        </div>
        <div class="form-card">
        <div class="language-wrapper">
          <div class="card-title">
            Default Language
          </div>
          <Dropdown v-model="selectedLanguage" :options="countries" optionLabel="name" placeholder="Select a Country" class="w-full ">
            <template #value="slotProps">
                <div v-if="slotProps.value" class="flex align-items-center">
                    <img :alt="slotProps.value.label" src="https://primefaces.org/cdn/primevue/images/flag/flag_placeholder.png" :class="`mr-2 flag flag-${slotProps.value.code.toLowerCase()}`" style="width: 34px" />
                    <div>{{ slotProps.value.name }}</div>
                </div>
                <span v-else>
                    {{ slotProps.placeholder }}
                </span>
            </template>
            <template #option="slotProps">
                <div class="flex align-items-center">
                    <img :alt="slotProps.option.label" src="https://primefaces.org/cdn/primevue/images/flag/flag_placeholder.png" :class="`mr-2 flag flag-${slotProps.option.code.toLowerCase()}`" style="width: 34px" />
                    <div>{{ slotProps.option.name }}</div>
                </div>
            </template>
          </Dropdown>
        </div>
          <div class="card-title">
            Translations
          </div>
          <div class="translations-wrapper">
            <img :alt="selectedLanguage?.label" src="https://primefaces.org/cdn/primevue/images/flag/flag_placeholder.png" :class="`mr-2 flag flag-${selectedLanguage?.code.toLowerCase()}`" style="width: 34px" />
            <InputText v-model="translation" style="width: 100%" />
          </div>
        </div>
        <div class="form-card">
          <div class="card-title">
            Featured Image/Video
          </div>
          <FileUpload name="demo[]" url="/api/upload" @upload="onAdvancedUpload($event)" :multiple="true" accept="image/*" :maxFileSize="1000000">
              <template #empty>
                <div class="upload-placeholder">                
                  <strong>Upload Featured Image/Video</strong>
                  <p>
                    Max upload file size:
                    Image &lt;500KB, Video &lt;1MB
                  </p>
                </div>
              </template>
          </FileUpload>
          </div>
      </div>
      <ConfirmDialog group="beforeNavigate">
          <template #message="slotProps">
              <div class="dialog-content">
                  <i :class="slotProps.message.icon"></i>
                  <div class="dialog-title">Confirm Navigation</div>
                  <div class="content-message border-bottom-1">
                    <div>{{ slotProps.message.messageL1 }}</div>
                    <div class="message-line2">{{ slotProps.message.messageL2 }}</div>
                  </div>
              </div>
          </template>
      </ConfirmDialog>
    </div>
</template>

<style lang="scss">
$blue: #0079E9;
$light-blue: #E6F2FD;
$gray-700: #A1A3A5;
.p-dropdown {
  width: 100%;
  border: 1px solid #E3E5E8;
}
.p-checkbox.p-highlight, .p-checkbox-box {
  background: $blue !important;
}
.p-dropdown-panel .p-dropdown-items .p-dropdown-item.p-highlight.p-focus {          
  background: $light-blue;
  color: black;
}
.post-add {
  width: 95%;
  margin: 24px;
  display: grid;
  grid-template-columns: 1fr 270px;
  gap: 20px;
  .left {
    min-width: 840px;
    .form-card {
      border-radius: 8px;
      // border: 1px solid #E0E2E7;
      background: white;
      padding: 18px 24px;
      margin-bottom: 1rem;
      box-shadow: 0px 4px 20px 4px rgba($color: #B7BACB, $alpha: 0.15);
      .input-wrapper {
        display: flex;
        flex-direction: column;
        &.spacing {
          margin-bottom: 1rem;
        }
        .p-multiselect {
          border: 1px solid #E3E5E8;
        }
        
      }
    }
    .label-required {
      color: #F15338;
    }
    .bottom-form {
      .form-title {
        font-size: 1.2rem;
      }
      .copy-url {
        display: flex;
        margin-left: 10px;
        span {
          margin-left: 4px;
          cursor: pointer;
        }
      }
    }
  }
  .right {
    .preview-btn {
      border: 1px solid $gray-700;
      color: $gray-700;
      width: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 6px;
      padding: 9px;
      background: rgba($color: #000000, $alpha: 0);
      cursor: pointer;
      border-radius: 6px;
      margin-bottom: 1rem;
      font-size: 14px;
      &:hover {
        background: rgba($color: $blue, $alpha: 0.04);
      }
    }
    .publish-btn {
      width: 100%;
      font-size: 14px;
      margin-bottom: 1rem;
      .p-button {
        background-color: $blue;
      }
      .p-button.p-button-outlined {
        color: white;
        border: 1px solid $blue;
        border-color: $blue;
      }
      .p-splitbutton-menubutton {
        background: $light-blue;
        color: $blue !important;
      }
    }
    .form-card {
      border-radius: 8px;
      // border: 1px solid #E0E2E7;
      background: white;
      padding: 18px 24px;
      margin-bottom: 1rem;
      box-shadow: 0px 4px 20px 4px rgba($color: #B7BACB, $alpha: 0.15);
      .card-title {
        font-size: 18px;
        font-weight: 800;
        margin-bottom: 14px;
      }
      .status-select {
        width: 100%;
        border: 1px solid #cbd5e1;
        
      }
      .date-wrapper {
        input {
          margin-bottom: 4px;
        }
        &.first {
          margin-bottom: 20px;

        }
      }
      .language-wrapper {
        margin-bottom: 1rem;
      }
      .translations-wrapper {
        display: flex;
        align-items: center;
      }
      .p-fileupload-buttonbar {
        display: none;
      }
      .p-fileupload-content {
        padding: 0;
      }
      .upload-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        background: #E3E5E8;
        font-size: 12px;
        padding: 36px 17px;
      }
    }
  }
}
.dialog-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  max-width: 320px;
  .dialog-title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
  }
  .pi-exclamation-circle {
    width: 65px;
    height: 65px;
    font-size: 3rem;
    color: #F15338;
  }
  .message-line2 {
    display: block;
    margin-top: 7px;
  }
}
.p-dialog-header-icons {
  position: absolute;
  right: 10px;
}
.reject-btn {
  border: 1px solid #A1A3A5;
  color: #A1A3A5;
}
.accept-btn {
  background-color: $blue;
  color: white;
}
</style>