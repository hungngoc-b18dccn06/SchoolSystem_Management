import ic_list from "@/assets/icons/ic_list.svg";
import ic_setting from "@/assets/icons/ic_setting.svg";

import PAGE_ROUTE from "./pageRoute";

export default [
    {
        items: [
            {
                label: "ホーム",
                icon: "pi pi-home",
                to: PAGE_ROUTE.HOME,
            },
        ],
    },
    {
        items: [
            {
                label: "管理者アカウント管理",
                icon: "pi pi-user",
                to: PAGE_ROUTE.USER_LIST,
                public:false,
            },
        ],
    },
    {
        items: [
            {
                label: "カテゴリー",
                icon: "pi pi-bookmark",
                to: PAGE_ROUTE.CATEGORY_LIST,
            },
            {
                label: "カテゴリー",
                icon: "pi pi-cog",
                items: [
                  {
                    icon: "pi pi-flag-fill",
                    label: "カテゴリー",
                    to: '/test'
                  },
                  {
                    icon: "pi pi-moon",
                    label: "方面/駐屯地",
                    to: "/garrison",
                    public: true,
                  },
                ],
              },
            
        ],
    },
    
];
