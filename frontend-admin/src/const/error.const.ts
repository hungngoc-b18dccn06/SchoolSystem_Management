export const ERROR_LIB = {
  medipurse: {
    url: import.meta.env.VITE_MEDIPURSE_DOMAIN,
    type: "Medipurse",
  },
  google: {
    url: import.meta.env.VITE_GOOGLE_API_URL,
    type: "Google",
  },
  interalServer: "ネットワークエラー",
  connectServer: "インターネットに接続されていません。",
  authServer: "このアカウントは存在しません",
};
