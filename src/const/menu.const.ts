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
        ],
    },
    // {
    //     items: [
    //         {
    //             label: "設定",
    //             icon: "pi pi-cog",
    //             to: "/",
    //         },
    //     ],
    // },
];
