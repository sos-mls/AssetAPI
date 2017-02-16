# AssetsAPI #

Exists to create, delete, and read an asset. The AssetsAPI is a centralized API endpoint that handles all asset creation.

## Why? ##

Receiving and sending assets can become quite task heavy. The uploading task takes into account asset manipulation for the MILF clients, reducing the asset until it only has the bare necessities, and caching the asset until destroyed. The storage task for MILF servers takes accounts for tracking usage and if there is none collecting that asset as garbage.