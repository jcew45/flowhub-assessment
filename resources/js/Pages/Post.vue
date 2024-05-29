<script setup>
import { ref, onMounted, getCurrentInstance } from 'vue';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import InputText from 'primevue/inputtext';
import CascadeSelect from 'primevue/cascadeselect';
import Button from 'primevue/button';
import { useRouter } from 'vue-router';
import CustomTable from '../Components/CustomTable.vue'
import axios from "axios";
import Skeleton from 'primevue/skeleton';


const { emit } = getCurrentInstance();

const searchValue = ref("")
const selectedLanguage = ref()
const selectedStatus = ref()
const countries = ref([
    {
        name: 'Australia',
        code: 'AU',
        states: [
            {
                name: 'New South Wales',
                cities: [
                    { cname: 'Sydney', code: 'A-SY' },
                    { cname: 'Newcastle', code: 'A-NE' },
                    { cname: 'Wollongong', code: 'A-WO' }
                ]
            },
            {
                name: 'Queensland',
                cities: [
                    { cname: 'Brisbane', code: 'A-BR' },
                    { cname: 'Townsville', code: 'A-TO' }
                ]
            }
        ]
    },
    {
        name: 'Canada',
        code: 'CA',
        states: [
            {
                name: 'Quebec',
                cities: [
                    { cname: 'Montreal', code: 'C-MO' },
                    { cname: 'Quebec City', code: 'C-QU' }
                ]
            },
            {
                name: 'Ontario',
                cities: [
                    { cname: 'Ottawa', code: 'C-OT' },
                    { cname: 'Toronto', code: 'C-TO' }
                ]
            }
        ]
    },
    {
        name: 'United States',
        code: 'US',
        states: [
            {
                name: 'California',
                cities: [
                    { cname: 'Los Angeles', code: 'US-LA' },
                    { cname: 'San Diego', code: 'US-SD' },
                    { cname: 'San Francisco', code: 'US-SF' }
                ]
            },
            {
                name: 'Florida',
                cities: [
                    { cname: 'Jacksonville', code: 'US-JA' },
                    { cname: 'Miami', code: 'US-MI' },
                    { cname: 'Tampa', code: 'US-TA' },
                    { cname: 'Orlando', code: 'US-OR' }
                ]
            },
            {
                name: 'Texas',
                cities: [
                    { cname: 'Austin', code: 'US-AU' },
                    { cname: 'Dallas', code: 'US-DA' },
                    { cname: 'Houston', code: 'US-HO' }
                ]
            }
        ]
    }
]);

const router = useRouter();

const toAddPost = () => {
    router.push('/post/add');
}

const response = ref();

const getValue = async () => {
    try {
        response.value = await axios.get("/api/post");
    } catch (error) {
        // Do something with the error
        console.log(error);
    }
};

const formatDate = (tableDate) => {
    let formattedTableDate = ref("")
    const date = new Date(tableDate);
    const options = {
        // weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
    };
    let formattedDate = date.toLocaleString('default', options);
    let time =   date.toLocaleTimeString([], { hour: "2-digit", minute: "2-digit", hour12: false })
    formattedTableDate.value = `${formattedDate} at ${time}`
    console.log(formattedTableDate.value);
    return formattedTableDate.value;
}

const formatNumber = (number) => {
    const formatter = new Intl.NumberFormat('en-US');

    return formatter.format(number);
}

onMounted(() => {
  const itemList = ref([
    { label: 'Post' }, 

    ]);
  emit('assignBreadCrumbs', itemList.value);
  getValue()
});

import ConfirmDialog  from 'primevue/confirmdialog';
import { useConfirm } from "primevue/useconfirm";
const confirm = useConfirm();

const openDelete = () => {
    confirm.require({
        group: 'beforeDelete',
        header: "",
        messageL1: 'Do you want to remove the page? This process cannot be undone.',
        messageL2: '',
        icon: 'pi pi-exclamation-circle',
        // acceptIcon: 'pi pi-check',
        // rejectIcon: 'pi pi-times',
        rejectClass: 'reject-btn p-button-outlined p-button-sm',
        acceptClass: 'delete-btn p-button-sm',
        rejectLabel: 'Cancel',
        acceptLabel: 'Delete',
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
    <div class="post">
        <div class="table-top">
            <div class="top-start">
                <!-- search input -->
                <IconField>
                    <InputIcon class="pi pi-search"> </InputIcon>
                    <InputText v-model="searchValue" placeholder="Search post by title" />
                </IconField>
            </div>
            <div class="top-end">
                Filter By: 
                <!-- filter lang -->
                <CascadeSelect v-model="selectedLanguage" :options="countries" optionLabel="cname" optionGroupLabel="name" :optionGroupChildren="['states', 'cities']" placeholder="English" />
                <!-- filter status -->
                <CascadeSelect v-model="selectedStatus" :options="countries" optionLabel="cname" optionGroupLabel="name" :optionGroupChildren="['states', 'cities']" placeholder="All Status" />
                <!-- create post button -->
                <Button label="Create Post" @click="toAddPost" class="add-btn" icon="pi pi-plus" />
            </div>
        </div>
        <div class="post-table">
            <CustomTable v-if="response" tableTitle="Post List">
                <div v-for="data in response.data" class="list-item" :key="`post${data.created_at+data.id}`">
                    <div class="item-start">                    
                        <!-- image -->
                        <img :src="data.image" :alt="`${data.title}image`">
                        <!-- desc -->
                        <div class="desc-wrapper">
                            <div class="title-wrapper">
                                <div class="item-title">{{ data.title }}</div>
                                <span :class="`status ${data.status}`">{{ data.status }}</span>
                            </div>
                            <div class="author">{{ data.author }}</div>
                            <div class="date">Date created: {{ data.created_at ? formatDate(data.created_at) : "" }}</div>
                        </div>
                    </div>
                    <div class="item-end">
                        <!-- action -->
                        <div class="action-wrapper">
                            <div class="action-buttons">
                                <button class="pi pi-pencil edit"></button>
                                <button @click="openDelete" class="pi pi-trash delete"></button>
                                <button class="pi pi-eye view"></button>
                            </div>
                            <div class="interactions">
                                <div class="comment">
                                    {{ data.comment ? formatNumber(data.comment) : "-" }}
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_1_4050)">
                                        <path d="M9.63016 0.14032H2.22349C1.7324 0.14032 1.26142 0.335406 0.914167 0.68266C0.566912 1.02992 0.371826 1.50089 0.371826 1.99199L0.371826 7.54699C0.371826 8.03808 0.566912 8.50906 0.914167 8.85631C1.26142 9.20357 1.7324 9.39865 2.22349 9.39865H3.56595L5.62639 11.1406C5.70998 11.2113 5.81594 11.2502 5.92544 11.2502C6.03494 11.2502 6.14089 11.2113 6.22448 11.1406L8.2877 9.39865H9.63016C10.1213 9.39865 10.5922 9.20357 10.9395 8.85631C11.2867 8.50906 11.4818 8.03808 11.4818 7.54699V1.99199C11.4818 1.50089 11.2867 1.02992 10.9395 0.68266C10.5922 0.335406 10.1213 0.14032 9.63016 0.14032V0.14032ZM3.61224 2.4549H5.92683C6.0496 2.4549 6.16734 2.50367 6.25416 2.59049C6.34097 2.6773 6.38974 2.79505 6.38974 2.91782C6.38974 3.04059 6.34097 3.15834 6.25416 3.24515C6.16734 3.33196 6.0496 3.38074 5.92683 3.38074H3.61224C3.48947 3.38074 3.37173 3.33196 3.28491 3.24515C3.1981 3.15834 3.14933 3.04059 3.14933 2.91782C3.14933 2.79505 3.1981 2.6773 3.28491 2.59049C3.37173 2.50367 3.48947 2.4549 3.61224 2.4549ZM8.24141 7.08407H3.61224C3.48947 7.08407 3.37173 7.0353 3.28491 6.94848C3.1981 6.86167 3.14933 6.74393 3.14933 6.62115C3.14933 6.49838 3.1981 6.38064 3.28491 6.29382C3.37173 6.20701 3.48947 6.15824 3.61224 6.15824H8.24141C8.36418 6.15824 8.48193 6.20701 8.56874 6.29382C8.65555 6.38064 8.70433 6.49838 8.70433 6.62115C8.70433 6.74393 8.65555 6.86167 8.56874 6.94848C8.48193 7.0353 8.36418 7.08407 8.24141 7.08407ZM8.24141 5.2324H3.61224C3.48947 5.2324 3.37173 5.18363 3.28491 5.09682C3.1981 5.01 3.14933 4.89226 3.14933 4.76949C3.14933 4.64671 3.1981 4.52897 3.28491 4.44215C3.37173 4.35534 3.48947 4.30657 3.61224 4.30657H8.24141C8.36418 4.30657 8.48193 4.35534 8.56874 4.44215C8.65555 4.52897 8.70433 4.64671 8.70433 4.76949C8.70433 4.89226 8.65555 5.01 8.56874 5.09682C8.48193 5.18363 8.36418 5.2324 8.24141 5.2324Z" fill="#8A9BAA"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_1_4050">
                                        <rect width="11.11" height="11.11" fill="white" transform="translate(0.371826 0.14032)"/>
                                        </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="view">
                                    {{ data.view ? formatNumber(data.view) : "-" }}
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_1_4053)">
                                        <path d="M6.14677 2.91785C6.51509 2.91785 6.86833 3.06416 7.12877 3.3246C7.38921 3.58504 7.53552 3.93828 7.53552 4.3066V9.8616C7.53552 10.2299 7.38921 10.5831 7.12877 10.8436C6.86833 11.104 6.51509 11.2503 6.14677 11.2503C5.77845 11.2503 5.42522 11.104 5.16478 10.8436C4.90434 10.5831 4.75802 10.2299 4.75802 9.8616V4.3066C4.75802 3.93828 4.90434 3.58504 5.16478 3.3246C5.42522 3.06416 5.77845 2.91785 6.14677 2.91785Z" fill="#8A9BAA"/>
                                        <path d="M1.98051 0.14032C2.34883 0.14032 2.70207 0.286634 2.96251 0.547075C3.22295 0.807516 3.36926 1.16075 3.36926 1.52907V9.86157C3.36926 10.2299 3.22295 10.5831 2.96251 10.8436C2.70207 11.104 2.34883 11.2503 1.98051 11.2503C1.61219 11.2503 1.25896 11.104 0.998518 10.8436C0.738077 10.5831 0.591763 10.2299 0.591763 9.86157V1.52907C0.591763 1.16075 0.738077 0.807516 0.998518 0.547075C1.25896 0.286634 1.61219 0.14032 1.98051 0.14032V0.14032Z" fill="#8A9BAA"/>
                                        <path d="M10.313 5.69531C10.6814 5.69531 11.0346 5.84163 11.295 6.10207C11.5555 6.36251 11.7018 6.71574 11.7018 7.08406V9.86156C11.7018 10.2299 11.5555 10.5831 11.295 10.8436C11.0346 11.104 10.6814 11.2503 10.313 11.2503C9.94471 11.2503 9.59148 11.104 9.33104 10.8436C9.0706 10.5831 8.92428 10.2299 8.92428 9.86156V7.08406C8.92428 6.71574 9.0706 6.36251 9.33104 6.10207C9.59148 5.84163 9.94471 5.69531 10.313 5.69531Z" fill="#8A9BAA"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_1_4053">
                                        <rect width="11.11" height="11.11" fill="white" transform="matrix(-1 0 0 1 11.7018 0.14032)"/>
                                        </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </CustomTable>
            <div v-else class="border-round border-1 surface-border p-4 surface-card loading-box">
                <ul class="m-0 p-0 list-none">
                    <li class="mb-3">
                        <div class="flex">
                            <Skeleton shape="circle" size="4rem" class="mr-2"></Skeleton>
                            <div class="align-self-center" style="flex: 1">
                                <Skeleton width="100%" class="mb-2"></Skeleton>
                                <Skeleton width="75%"></Skeleton>
                            </div>
                        </div>
                    </li>
                    <li class="mb-3">
                        <div class="flex">
                            <Skeleton shape="circle" size="4rem" class="mr-2"></Skeleton>
                            <div class="align-self-center" style="flex: 1">
                                <Skeleton width="100%" class="mb-2"></Skeleton>
                                <Skeleton width="75%"></Skeleton>
                            </div>
                        </div>
                    </li>
                    <li class="mb-3">
                        <div class="flex">
                            <Skeleton shape="circle" size="4rem" class="mr-2"></Skeleton>
                            <div class="align-self-center" style="flex: 1">
                                <Skeleton width="100%" class="mb-2"></Skeleton>
                                <Skeleton width="75%"></Skeleton>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="flex">
                            <Skeleton shape="circle" size="4rem" class="mr-2"></Skeleton>
                            <div class="align-self-center" style="flex: 1">
                                <Skeleton width="100%" class="mb-2"></Skeleton>
                                <Skeleton width="75%"></Skeleton>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <ConfirmDialog group="beforeDelete">
          <template #message="slotProps">
              <div class="dialog-content">
                  <i :class="slotProps.message.icon"></i>
                  <div class="dialog-title">Confirm Delete Post?</div>
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
$blue: #7867FF;
$light-blue: #E6F2FD;
$red: #F15338;
$green: #54B86E;
$gray: #A1A3A5;
.post {
    .table-top {
        display: flex;
        justify-content: space-between;
        padding: 1rem;
        .top-end {
            display: flex;
            gap: 10px;
            align-items: center;
            .add-btn {
                background: $blue;
            }
        }
    }
    .post-table {
        .list-item {
            background: white;
            transition: 0.5s;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            &:hover {
                background: $light-blue;
            }
            .item-start {
                display: flex;
                align-items: center;
                gap: 14px;
                .title-wrapper {
                    display: flex;
                    gap: 4px;
                    .item-title {
                        font-weight: 600;
                    }
                }
                .status {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-width: 45px;
                    border-radius: 4px;
                    color: white;
                    padding: 0 6px;
                    &.published {
                        background-color: $green;
                    }
                    &.draft {
                        background-color: $red;
                    }
                    &.hidden {
                        background-color: $gray;
                    }
                }
            }
            .item-end {
                .action-wrapper {
                    display: flex;
                    flex-direction: column;
                    align-items: end;
                    .action-buttons {
                        display: flex;
                        gap: 12px;
                        button {
                            cursor: pointer;
                            background: none;
                            &.edit {
                                color: $blue;
                            }
                            &.delete {
                                color: $red;
                            }
                        }
                    }
                }
                .interactions, .comment, .view {
                    display: flex;
                    align-items: center;
                }
                .interactions {
                    gap: 12px;
                    .comment, .view {
                        gap: 4px;
                    }
                }
            }
        }
        .loading-box {
            background: white;
            border-radius: 12px;
            ul {
                list-style: none;
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
.delete-btn {
    background: #F15338;
    color: white;
}
.reject-btn {
    border: 1px solid #A1A3A5;
    color: #A1A3A5;
}
.p-dialog-footer {
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>