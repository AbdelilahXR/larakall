1. Table: `users`
   - `id`
   - `username`
   - `email`
   - `password`
   - `roles_id`

2. Table: `products`
   - `id`
   - `name`
   - `script`
   - `upsell`
   - `image_1`
   - `image_2`
   - `image_3`
   - `link`
   - `description`
   - `min_price`
   - `max_price`

3. Table: `stores`
   - `id`
   - `name`
   - `plateforme`
   - `link`
   - `users_id`

4. Table: `companies`
   - `id`
   - `name`
   - `api`

5. Table: `orders`
   - `id`
   - `code`
   - `reference`
   - `name`
   - `client`
   - `phone`
   - `price`
   - `city`
   - `adress`
   - `information`
   - `products_id`
   - `stores_id`
   - `companies_id`

6. Table: `states`
   - `id`
   - `name`
   - `color`
   - `type`

7. Table: `states_orders`
   - `states_id`
   - `orders_id`
   - `users_id`

8. Table: `payments`
   - `id`
   - `amount`
   - `state`
   - `paid_at`
   - `orders_id`

9. Table: `messages`
   - `id`
   - `message`
   - `orders_id`
   - `messages_id`
   - `type`

10. Table: `stocks`
    - `id`
    - `name`
    - `quantity`
    - `price`
    - `products_id`

11. Table: `orders_users`
    - `orders_id`
    - `users_id`

12. Table: `packs`
    - `id`
    - `name`
    - `feautures`
    - `price`

13. Table: `subscriptions`
    - `id`
    - `packs_id`
    - `users_id`

1. Table: `users` <done>
2. Table: `products` <done>
3. Table: `stores` <done>
4. Table: `companies` <done>
5. Table: `orders` <done>
6. Table: `states` <done>
7. Table: `states_orders`
8. Table: `payments` <done>
9. Table: `messages` <done>
10. Table: `stocks` <done>
11. Table: `orders_users` <done>
12. Table: `packs` <done>
13. Table: `subscriptions` <done>


