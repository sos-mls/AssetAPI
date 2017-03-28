# AssetsAPI #

Exists to create, delete, and read an asset. The AssetsAPI is a centralized API endpoint that handles all asset creation.

## Why? ##

Receiving and sending assets can become quite task heavy. The uploading task takes into account asset manipulation for the MILF clients, reducing the asset until it only has the bare necessities, and caching the asset until destroyed. The storage task for MILF servers takes accounts for tracking usage and if there is none collecting that asset as garbage. 

## C.R.D. ##

The decision to stick with only create, read, and delete is a simplification in implementation. When an asset needs to exist we create it, allowing it to be read; when an asset is no longer necessary, should be read, we delete that asset.

This mentality allows for clean design philosophy with no other use cases. If an asset needs to be updated it can be updated on the client side as a new asset, removing the old asset.
